<?php
/**
 * This class manages active user sessions and related security. Any user can have
 * several sessions on multiple devices.
 * 
 * A primary concern of this class is keeping our database table of user sessions and the
 * user's cookies in sync. We always err on the side of caution and destroy any sessions
 * that don't look right.
 * 
 * The basic design of our sessions is as follows:
 * A new session is created each time a user signs in on a new device. 
 * The session consists of an identifying pair of the user_id and a random token. 
 * Additionally, the user's browser is assigned a nonce which we use for security.
 * Each time the user's session is validated, we look up the appropriate session using
 * the user_id and token stored in the browser's cookies. Then the current nonce is read 
 * from the user's browser and compared to what is stored in our database. 
 * If the nonce is valid, the session is concidered valid. 
 * After each validation, the nonce is changed to a new random hash.
 */
class UserSessionManager extends CComponent {
	const COOKIE_ACTIVE_USER = "active_user";
	const COOKIE_SESSION_TOKEN = "session_token";
	const COOKIE_SESSION_NONCE = "session_nonce";
	
	// The dirty flag lets us know if cookies have been set recently. This is important
	// because we can't read recently written cookies until after the user's browser reloads.
	private static $dirty = false;
	private static $last_data = null;
	
	/**
	 * This method creates a new session and records the data to both the DB and the user's cookies.
	 * @param Int $user_id
	 */
	public static function initSession($user_id) {
		self::clearAllSessionCookies();
		
		$token = self::generateRandomToken($user_id);
		$nonce = self::generateRandomToken($user_id);
		
		// Set session cookies in user browser
		self::setCookie(self::COOKIE_ACTIVE_USER, $user_id);
		self::setCookie(self::COOKIE_SESSION_TOKEN, $token);
		self::setCookie(self::COOKIE_SESSION_NONCE, $nonce);
		self::setDirtyData($user_id, $token, $nonce);
		
		self::recordSession($user_id, $token, $nonce);
	}
	
	private static function destroySession($token) {
		self::clearAllSessionCookies();
		
		$session = UserSession::model()->find('token=:token', array(':token'=>$token));
		if($session != null) {
			$cacheKey = self::buildSessionCacheKey($session->user_id, $token);
			CacheManager::getInstance()->delete($cacheKey);
			
			$session->delete();
		}
	}
	
	/**
	 * This method will search the user's cookies for an active session and, if found, will destroy that session.
	 */
	public static function destroyCurrentSession() {
		$token = self::$dirty ? self::$last_data['token'] : self::getCookie(self::COOKIE_SESSION_TOKEN);
		
		if($token != null) {
			self::destroySession($token);
		}
	}
	
	private static function buildSessionCacheKey($user_id, $token) {
		return "session:".$user_id.$token;
	}
	
	/**
	 * This method checks for the existance of an active user session cookie, then validates any found 
	 * before returning the associated user id.
	 * @return The id of the user associated with the active session or false if there is no valid session.
	 */
	public static function getCurrentUserId() {
		$user_id = self::$dirty ? self::$last_data['user_id'] : self::getCookie(self::COOKIE_ACTIVE_USER);

		if($user_id == null) {
			// No active session
			return false;
		}
		
		$token = self::$dirty ? self::$last_data['token'] : self::getCookie(self::COOKIE_SESSION_TOKEN);

		if($token == null) {
			// Error case: there was a user_id but no token. Possible tampering.
			self::clearAllSessionCookies();
			return false;
		}
		
		// Search the cache for session nonce before hitting the DB
		$cacheKey = self::buildSessionCacheKey($user_id, $token);
		if(!($local_nonce = CacheManager::getInstance()->get($cacheKey))) {
			// Try to find session with matching user_id and token
			$session = UserSession::model()->find('user_id=:user_id AND token=:token', array(':user_id'=>$user_id, ':token'=>$token));
			
			if($session == null) {
				// No matching session in DB. Invalid.
				self::clearAllSessionCookies();
				return false;
			} else if(CDateTimeParser::parse($session->expires,'yyyy-MM-dd hh:mm:ss') < time()) {
				// Session has expired and therefor invalid. Clean it up.
				$session->delete();
				self::clearAllSessionCookies();
				return false;
			}
			$local_nonce = $session->nonce;
		}
		
		// Validate the nonce
		$read_nonce = self::$dirty ? self::$last_data['nonce'] : self::getCookie(self::COOKIE_SESSION_NONCE);
		
		if($read_nonce == null) {
			// No nonce? No go
			self::destroySession($token);
			return false;
		} else if ($read_nonce != $local_nonce) {
			// Nonce doesn't match expected indicates clear case of tampering (specifically, copied cookies on multiple devices)
			self::destroySession($token);
			return false;
		}
		
		// Everything looks good! Update the nonce and return the user ID
		$new_nonce = self::updateSessionNonce($user_id, $token);
		
		// Save the new_nonce in the cache for an hour.
		CacheManager::getInstance()->set($cacheKey, $new_nonce, 60 * 60);
		
		return $user_id;
	}
	
	/**
	 * This method checks for the existance of an active user session cookie, then validates any found.
	 */
	public static function validSessionExists() {
		$user_id = self::getCurrentUserId();
		if(!$user_id) {
			return false;
		}
	}
	
	/**
	 * This method generates a new nonce then saves it in the user's cookies and the DB
	 * @param unknown $user_id
	 * @param unknown $token
	 */
	private static function updateSessionNonce($user_id, $token) {
		$new_nonce = self::generateRandomToken($user_id);
		self::setCookie(self::COOKIE_SESSION_NONCE, $new_nonce);
		self::setDirtyData($user_id, $token, $new_nonce);
		
		$session = UserSession::model()->find('user_id=:user_id AND token=:token', array(':user_id'=>$user_id, ':token'=>$token));
		$session->nonce = $new_nonce;
		$session->expires = new CDbExpression('NOW() + INTERVAL 30 DAY');
		$session->save();
		
		return $new_nonce;
	}
	
	/**
	 * This method records the session data to the database for future verification
	 * @param Int $user_id
	 * @param string $token
	 * @param string $nonce
	 */
	private static function recordSession($user_id, $token, $nonce) {
		$session = new UserSession();
		$session->user_id = $user_id;
		$session->token = $token;
		$session->nonce = $nonce;
		$session->expires = new CDbExpression('NOW() + INTERVAL 30 DAY');
		$session->save();
	}
	
	private static function clearAllSessionCookies() {
		unset(Yii::app()->request->cookies[self::COOKIE_ACTIVE_USER]);
		unset(Yii::app()->request->cookies[self::COOKIE_SESSION_TOKEN]);
		unset(Yii::app()->request->cookies[self::COOKIE_SESSION_NONCE]);
		self::setDirtyData(null, null, null);
	}
	
	private static function setDirtyData($user_id, $token, $nonce) {
		self::$dirty = true;
		self::$last_data = array(
				'user_id' => $user_id,
				'token' => $token,
				'nonce' => $nonce
				);
	}
	
	private static function setCookie($cookie_name, $value) {
		Yii::app()->request->cookies[$cookie_name] = new CHttpCookie($cookie_name, self::encrypt($value));
	}
	
	private static function getCookie($cookie_name) {
		if(!isset(Yii::app()->request->cookies[$cookie_name])) {
			return null;
		}
		
		return self::decrypt(Yii::app()->request->cookies[$cookie_name]->value);
	}
	
	private static function generateRandomToken($user_id) {
		return md5(uniqid($user_id, true));
	}
	
	private static function encrypt($value) {
		return Yii::app()->getSecurityManager()->encrypt($value);
	}
	
	private static function decrypt($value) {
		// Check for invalid input data (usually a result of changing encryption)
		if(strlen($value) < 8) {
			return null;
		}
	
		return Yii::app()->getSecurityManager()->decrypt($value);
	}
}
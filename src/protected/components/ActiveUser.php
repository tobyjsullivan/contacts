<?php
class ActiveUser extends CComponent {
	const COOKIE_NAME = "active_user";
	private static $activeUser = null;
	/** 
	 * The $hasBeenCleared var helps us differentiate between a deleted active 
	 * user and one that hasn't been loaded yet (since the cookie won't update 
	 * until the next page load).
	 */
	private static $hasBeenCleared = false;
	
	public static function setActiveUser($user_id) {
		self::$activeUser = $user_id;
		self::$hasBeenCleared = true;
		Yii::app()->request->cookies[self::COOKIE_NAME] = new CHttpCookie(self::COOKIE_NAME, self::encrypt($user_id));
	}
	
	public static function getActiveUser() {
		// If the active user has already been read/recently set
		if(self::$activeUser != null || self::$hasBeenCleared) {
			return self::$activeUser;
		} 
		
		// Otherwise try reading the active user from the user's cookies
		if(isset(Yii::app()->request->cookies[self::COOKIE_NAME])) {
			self::$activeUser = self::decrypt(Yii::app()->request->cookies[self::COOKIE_NAME]->value);
		}
		
		// Return the found user or null
		return self::$activeUser;
	}
	
	public static function clearActiveUser() {
		self::$activeUser = null;
		self::$hasBeenCleared = true;
		unset(Yii::app()->request->cookies[self::COOKIE_NAME]);
	}
	
	private static function encrypt($value) {
		// TODO
		return $value;
	}
	
	private static function decrypt($value) {
		// TODO
		return $value;
	}
}
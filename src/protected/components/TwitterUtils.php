<?php
require_once('twitteroauth.php');
require_once('CacheManager.php');
require_once('UserSessionManager.php');

/**
 * This class wraps all communications with the Twitter API.
 * @author tobyjsullivan
 *
 */
class TwitterUtils extends CComponent {
	/**
	 * This method produces a Twitter API URL that we can redirect users to for sign in.
	 * @return string
	 */
	public static function getSignInUrl() {
		// Initialise the OAuth object
		$conn = self::buildTwitterConnection();
		
		// Get temporary credentials for authorisation. 
		// The callback URL is actually ignored by the 1.1 version of the Twitter API.
		$callbackUrl = 'http://contacts.tobysullivan.net/index.php?r=auth/callback';
		$temp_creds = $conn->getRequestToken($callbackUrl);

		// Store temp credentials for use in callback
		Yii::app()->session['oauth_token'] = $temp_creds['oauth_token'];
		Yii::app()->session['oauth_token_secret'] = $temp_creds['oauth_token_secret'];
		
		// Get the callback URL
		$redirectUrl = $conn->getAuthorizeURL($temp_creds);
		
		return $redirectUrl;
	}
	
	/**
	 * This method is to be run after the twitter callback. It will only work with the tokens saved in the session in getSignInUrl()
	 * @return array Returns the credential array or false if the credentails can't be obtained.
	 */
	public static function getLongTermCredentials() {
		// A lack of token data in the session is an odd error state
		// The oauth_verifier will not be present in the request if the user opts to not grant permission (and probably in other expected cases)
		if(!isset(Yii::app()->session['oauth_token']) || !isset(Yii::app()->session['oauth_token_secret']) ||
				!isset($_REQUEST['oauth_verifier'])) {
			return false;
		}
		
		// Read temp credentials that were set previously in getSignInUrl()
		$temp_auth_token = Yii::app()->session['oauth_token'];
		$temp_auth_token_secret = Yii::app()->session['oauth_token_secret'];
		
		$temp_conn = self::buildTwitterConnection($temp_auth_token, $temp_auth_token_secret);
		
		// Hit the twitter API to swap our verifier code for persistent, long-term credentials
		$token_creds = $temp_conn->getAccessToken($_REQUEST['oauth_verifier']);
		
		// Return the token credential array directly
		return $token_creds;
	}
	
	/**
	 * This method takes a Twitter token/secret pair and determines if they are valid
	 * @param string $auth_token
	 * @param string $auth_token_secret
	 * @param string $force_check This flag is used to bypass caching and hit the Twitter API every time
	 * @return Int The twitter user id for the account associated with the credentials or false if the credentials are invalid.
	 */
	public static function validateToken($auth_token, $auth_token_secret, $force_check = false) {
		if(empty($auth_token) || empty($auth_token_secret)) {
			return false;
		}

		$cacheKey = "creds:".$auth_token.$auth_token_secret;
		if(!$force_check && !YII_DEBUG) {
			if($twitter_id = CacheManager::getInstance()->get($cacheKey)) {
				return $twitter_id;
			}
		}
		
		
		$conn = self::buildTwitterConnection($auth_token, $auth_token_secret);
		
		// Attempt to retreive account details from the twitter API
		$account = $conn->get('account/verify_credentials');
		
		if(isset($account->error) || isset($account->errors)) {
			return false;
		}

		// Cache valid creds for 8 hours
		CacheManager::getInstance()->set($cacheKey, $account->id, 60 * 60 * 8);
		
		return $account->id;
	}
	
	/**
	 * This method takes a twitter handle (excluding the @-symbol) and returns the number of followers.abstract
	 * The maximum number returned is 5000 for performance reasons and all error cases result in 0.
	 * @param string $twitterHandle
	 * @return number
	 */
	public static function getFollowerCount($twitterHandle) {
		// Standardise casing so we don't end up re-working unnecessarily
		$twitterHandle = strtolower($twitterHandle);

		$cacheKey = "follower_count:".$twitterHandle;
		if(!YII_DEBUG) {
			if($count = CacheManager::getInstance()->get($cacheKey)) {
				return $count;
			}
		}
		
		$user_id = UserSessionManager::getCurrentUserId();
		
		if(YII_DEBUG && !$user_id) {
			$accessToken = '93370723-3MlkNH3ChTxzf9U6wTDADcAO3sgtcgiObbEKhThg4';
			$accessTokenSecret = 'kaoX8S03GVwqNRLmH0YVzJE5gc1DMo3XPU1Tn4J1o';
		} else if(!$user_id) {
			return 0;
		} else {
			
			$user = User::model()->find('user_id=:user_id', array(':user_id'=>$user_id));
			if($user == null) {
				return 0;
			}
			
			$accessToken = $user->auth_token;
			$accessTokenSecret = $user->auth_token_secret;
		}
		
		$conn = self::buildTwitterConnection($accessToken, $accessTokenSecret);
		
		// Hit the twitter API for the user's display details. These include the number of followers.
		$followers = $conn->get('users/show', array('screen_name' => $twitterHandle));
		
		if(isset($followers->error) || isset($followers->errors)) {
			// In event of error, we don't want to return immediately because we still want this in the cache.
			// It is more likely the error is caused by a bad twitter handle than something more temporary list
			// bad tokens so this is acceptable.
			$count = 0;
		} else {
			$count = $followers->followers_count;
		}
		
		// Cache data for 24 hours
		CacheManager::getInstance()->set($cacheKey, $count, 60 * 60 * 24);
		
		return $count;
	}
	
	/**
	 * A simple helper method to help with the repetative task of building the oauth object
	 * @param string $auth_token
	 * @param string $auth_token_secret
	 */
	private static function buildTwitterConnection($auth_token = NULL, $auth_token_secret = NULL) {
		$consumer_key = Yii::app()->params['twitterConsumerKey'];
		$consumer_secret = Yii::app()->params['twitterConsumerSecret'];
		
		return new TwitterOAuth($consumer_key, $consumer_secret, $auth_token, $auth_token_secret);
	}
}
<?php
require_once('twitteroauth.php');
require_once('CacheManager.php');
require_once('ActiveUser.php');

class TwitterUtils extends CComponent {
	
	/**
	 * A simple helper method to help with the repetative task of building the oauth object
	 * @param string $auth_token
	 * @param string $auth_token_secret
	 */
	private static function buildTwitterOAuth($auth_token = NULL, $auth_token_secret = NULL) {
		$consumer_key = Yii::app()->params['twitterConsumerKey'];
		$consumer_secret = Yii::app()->params['twitterConsumerSecret'];
		
		return new TwitterOAuth($consumer_key, $consumer_secret, $auth_token, $auth_token_secret);
	}
	
	/**
	 * This method produces a Twitter API URL that we can redirect users to for sign in.
	 * @return string
	 */
	public static function getSignInUrl() {
		$callbackUrl = 'http://contacts.tobysullivan.net/index.php?r=auth/callback';
		
		// Initialise the OAuth object
		$conn = self::buildTwitterOAuth();
		
		// Get temporary credentials for authorisation
		$temp_creds = $conn->getRequestToken($callbackUrl);

		// Store temp credentials for use in callback
		$_SESSION['oauth_token'] = $temp_creds['oauth_token'];
		$_SESSION['oauth_token_secret'] = $temp_creds['oauth_token_secret'];
		
		// Get the callback URL
		$redirectUrl = $conn->getAuthorizeURL($temp_creds);
		
		return $redirectUrl;
	}
	
	/**
	 * This method is to be run after the twitter callback
	 */
	public static function getLongTermCredentials() {
		$temp_auth_token = $_SESSION['oauth_token'];
		$temp_auth_token_secret = $_SESSION['oauth_token_secret'];
		
		$temp_conn = self::buildTwitterOAuth($temp_auth_token, $temp_auth_token_secret);
		
		$token_creds = $temp_conn->getAccessToken($_REQUEST['oauth_verifier']);
		
		// Return the token credential array
		return $token_creds;
	}
	
	/**
	 * This method takes a Twitter token/secret pair and determines if they are valid
	 * @param string $auth_token
	 * @param string $auth_token_secret
	 * @param string $force_check This flag is used to bypass caching and hit the Twitter API every time
	 * @return boolean
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
		
		
		$conn = self::buildTwitterOAuth($auth_token, $auth_token_secret);
		
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
		// Standardise casing so we don't end up re-working for different casing.
		$twitterHandle = strtolower($twitterHandle);
		
		$cacheKey = "follower_count:".$twitterHandle;
		if(!YII_DEBUG) {
			if($count = CacheManager::getInstance()->get($cacheKey)) {
				return $count;
			}
		}
		
		// User access tokens
		// Defaults for debug mode
		$accessToken = '93370723-3MlkNH3ChTxzf9U6wTDADcAO3sgtcgiObbEKhThg4';
		$accessTokenSecret = 'kaoX8S03GVwqNRLmH0YVzJE5gc1DMo3XPU1Tn4J1o';
		
		// Load from user data
		if(!YII_DEBUG) {
			$user_id = ActiveUser::getActiveUser();
			if($user_id != null) {
				$user = User::model()->find('user_id=:user_id', array(':user_id'=>$user_id));
				if($user != null) {
					$accessToken = $user->access_token;
					$accessTokenSecret = $user->access_token_secret;
				}
			}
		}
		
		$conn = self::buildTwitterOAuth($accessToken, $accessTokenSecret);
		
		$followers = $conn->get('followers/ids', array('screen_name' => $twitterHandle));
		
		if(isset($followers->error) || isset($followers->errors)) {
			$count = 0;
		} else {
			$count = count($followers->ids);
		}
		
		// Cache data for 24 hours
		CacheManager::getInstance()->set($cacheKey, $count, 60 * 60 * 24);
		
		return $count;
	}
}
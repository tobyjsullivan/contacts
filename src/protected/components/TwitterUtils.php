<?php
require_once('twitteroauth.php');
require_once('CacheManager.php');
require_once('ActiveUser.php');

class TwitterUtils extends CComponent {
	/**
	 * This method produces a Twitter API URL that we can redirect users to for sign in.
	 * @return string
	 */
	public static function getSignInUrl() {
		$consumerKey = Yii::app()->params['twitterConsumerKey'];
		$consumerSecret = Yii::app()->params['twitterConsumerSecret'];
		
		$callbackUrl = 'http://contacts.tobysullivan.net/callback';
		
		// Initialise the OAuth object
		$conn = new TwitterOAuth($consumerKey, $consumerSecret);
		
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
	 * This method takes a twitter handle (excluding the @-symbol) and returns the number of followers.abstract
	 * The maximum number returned is 5000 for performance reasons and all error cases result in 0.
	 * @param string $twitterHandle
	 * @return number
	 */
	public static function getFollowerCount($twitterHandle) {
		// Standardise casing so we don't end up re-working for different casing.
		$twitterHandle = strtolower($twitterHandle);
		
		$cacheKey = "follower_count:".$twitterHandle;
		if(!defined('YII_DEBUG')) {
			if($count = CacheManager::getInstance()->get($cacheKey)) {
				return $count;
			}
		}
		
		
		$consumerKey = Yii::app()->params['twitterConsumerKey'];
		$consumerSecret = Yii::app()->params['twitterConsumerSecret'];
		
		// User access tokens
		// Defaults for debug mode
		$accessToken = '93370723-3MlkNH3ChTxzf9U6wTDADcAO3sgtcgiObbEKhThg4';
		$accessTokenSecret = 'kaoX8S03GVwqNRLmH0YVzJE5gc1DMo3XPU1Tn4J1o';
		
		// Load from user data
		if(!defined('YII_DEBUG')) {
			$user_id = ActiveUser::getActiveUser();
			if($user_id != null) {
				$user = User::model()->find('user_id=:user_id', array(':user_id'=>$user_id));
				if($user != null) {
					$accessToken = $user->access_token;
					$accessTokenSecret = $user->access_token_secret;
				}
			}
		}
		
		$conn = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);
		
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
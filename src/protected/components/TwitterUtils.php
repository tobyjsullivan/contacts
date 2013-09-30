<?php
require('twitteroauth.php');
require('CacheManager.php');

class TwitterUtils extends CComponent {
	public static function getFollowerCount($twitterHandle) {
		// Standardise casing so we don't end up re-working for different cases.
		$twitterHandle = strtolower($twitterHandle);
		
		$cacheKey = "followers:".$twitterHandle;
		if($count = CacheManager::getInstance()->get($cacheKey)) {
			return $count;
		}
		
		
		$consumerKey = Yii::app()->params['twitterConsumerKey'];
		$consumerSecret = Yii::app()->params['twitterConsumerSecret'];
		
		// Temporary token. Should be read from twitter signin
		$accessToken = '93370723-3MlkNH3ChTxzf9U6wTDADcAO3sgtcgiObbEKhThg4';
		$accessTokenSecret = 'kaoX8S03GVwqNRLmH0YVzJE5gc1DMo3XPU1Tn4J1o';
		
		$conn = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);
		
		$account = $conn->get('account/verify_credentials');
		
		$handle = $account->screen_name;
		
		$followers = $conn->get('followers/ids', array('screen_name' => $twitterHandle));
		
		$count = count($followers->ids);
		
		CacheManager::getInstance()->set($cacheKey, $count);
		
		return $count;
	}
}
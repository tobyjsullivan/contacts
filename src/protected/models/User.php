<?php
class User extends CActiveRecord
{
	public static function findOrCreate($twitter_id) {
		$user = self::model()->find('twitter_id=:twitter_id', array(':twitter_id'=>$twitter_id));
		
		if($user == null) {
			$user = new User;
			$user->twitter_id = $twitter_id;
			$user->save();
		}
		
		return $user;
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'tbl_users';
	}
	
	/**
	 * This method reads the user's twitter credentials and validates them against the server
	 */
	public function validateTwitterToken() {
		$auth_token = $this->auth_token;
		$auth_token_secret = $this->auth_token_secret;
		
		if(empty($auth_token) || empty($auth_token_secret)) {
			return false;
		}
		
		$twitter_id = TwitterUtils::validateToken($auth_token, $auth_token_secret, false);
		
		return $twitter_id == $this->twitter_id;
	}
}
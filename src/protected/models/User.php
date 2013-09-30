<?php
class User extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'tbl_users';
	}
	
	public static function findOrCreate($twitter_id) {
		$user = self::model()->find('twitter_id=:twitter_id', array(':twitter_id'=>$twitter_id));
		
		if($user == null) {
			$user = new User;
			$user->twitter_id = $twitter_id;
			$user->save();
		}
		
		return $user;
	} 
}
<?php

class UserTest extends CDbTestCase {
	public function testCreateNew() {
		$user = new User;
		$user->twitter_id = "827410";
		$user->save();
		
		$user_id = $user->user_id;
		
		$this->assertNotEquals("0", $user_id);
		
		// Find the user by twitter id
		$foundUser = User::model()->find('twitter_id=:twitter_id', array(':twitter_id'=>"827410"));
		
		// Confirm same user id is found
		$this->assertEquals($user_id, $foundUser->user_id);
	}
}
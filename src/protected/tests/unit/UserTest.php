<?php

class UserTest extends CDbTestCase {
	public $fixtures = array(
			'users' => 'User'
		);
	
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
	
	public function testSetAuthToken() {
		$user = $this->users('sample1');
		$user->auth_token = '1234567-3MlkNH3ChTxzf9U6wTDADcAO3sgtcgiObbEKhThg4';
		$user->auth_token_secret = 'cndX8S03GVwqNRLmH0YVzJE5gc1DMo3XPU1Tn4J1o';
		$user->save();

		$foundUser = User::model()->find('auth_token=:auth_token', array(':auth_token'=>"1234567-3MlkNH3ChTxzf9U6wTDADcAO3sgtcgiObbEKhThg4"));
		
		$this->assertNotNull($foundUser);
		$this->assertEquals('cndX8S03GVwqNRLmH0YVzJE5gc1DMo3XPU1Tn4J1o', $foundUser->auth_token_secret);
	}
	
	public function testFindOrCreateWithExisting() {
		$twitter_id = $this->users['sample2']['twitter_id'];
		
		$this->assertEquals("8219037293", $twitter_id);
		
		$user = User::findOrCreate($twitter_id);
		
		$this->assertNotNull($user);
		
		$expected_user_id = $this->users['sample2']['user_id'];
		
		$this->assertEquals($expected_user_id, $user->user_id);
	}
	
	public function testFindOrCreateWithNew() {
		$twitter_id = rand(10000000, 90000000);
		$user = User::findOrCreate($twitter_id);
		
		$this->assertNotNull($user);
		
		// Whatever id the new user was assigned should be larger than our sample data
		$this->assertGreaterThan($this->users['sample2']['user_id'], $user->user_id);
	}
}
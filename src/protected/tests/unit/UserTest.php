<?php

class UserTest extends CDbTestCase {
	public function testCreateNew() {
		$user = new User;
		$user->twitter_id = "827410";
		$user->save();
		
		$user_id = $user->user_id;
		
		$this->assertNotEquals("0", $user_id);
	}
}
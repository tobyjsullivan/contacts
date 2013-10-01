<?php

class UserSessionManagerTest extends CDbTestCase {
	public $fixtures = array(
			'users' => 'User'
		);
	
	/**
	 * This method tests the validSessionExists method returns false when there is no session
	 */
	public function testValidSessionExists_NoSession() {
		$res = UserSessionManager::validSessionExists();
		
		$this->assertFalse($res);
	}
}
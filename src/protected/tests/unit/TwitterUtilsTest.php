<?php
class TwitterUtilsTest extends CTestCase {
	public function testGetSignInUrl() {
		$url = TwitterUtils::getSignInUrl();
		
		$this->assertNotNull($url);
		$this->assertStringStartsWith("https://", $url);
	}
	
	public function testGetFollowerCount() {
		$twitter_handle = "TestUse57789104";
		$expected_result = 2;
		
		$retVal = TwitterUtils::getFollowerCount($twitter_handle);
		
		$this->assertEquals($expected_result, $retVal);
	}
	
	public function testGetFollowerCountForBadHandle() {
		$twitter_handle = "thishandleiswaytoolongrightguys";
		
		$retVal = TwitterUtils::getFollowerCount($twitter_handle);
		
		$this->assertEquals(0, $retVal);
	}
	
	public function testGetFollowerCountForProtected() {
		$twitter_handle = "TestUse26541783";
		
		$retVal = TwitterUtils::getFollowerCount($twitter_handle);
		
		$this->assertEquals(0, $retVal);
	}
	
}
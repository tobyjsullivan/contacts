<?php
class TwitterUtilsTest extends CTestCase {
	public function testGetSignInUrl() {
		if(empty(Yii::app()->params['twitterConsumerKey'])) {
			$this->markTestSkipped('Twitter API Key is not configured.');
			return;
		}

		$url = TwitterUtils::getSignInUrl();

		$this->assertNotNull($url);
		$this->assertStringStartsWith("https://", $url);
	}

	public function testValidateToken_Invalid() {
		$auth_token = "Gibberish";
		$auth_token_secret = "BadSecret";

		$res = TwitterUtils::validateToken($auth_token, $auth_token_secret);

		$this->assertFalse($res);
	}

	public function testGetFollowerCount() {
		if(empty(Yii::app()->params['twitterConsumerKey'])) {
			$this->markTestSkipped('Twitter API Key is not configured.');
			return;
		}

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
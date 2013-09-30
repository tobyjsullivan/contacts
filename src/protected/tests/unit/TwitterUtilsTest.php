<?php
class TwitterUtilsTest extends CTestCase {
	public function testGetFollowerCount() {
		$twitter_handle = "TestUse57789104";
		$expected_result = 2;
		
		$retVal = TwitterUtils::getFollowerCount($twitter_handle);
		
		$this->assertEquals($expected_result, $retVal);
	}
}
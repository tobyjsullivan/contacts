<?php
class AuthController extends Controller {
	/**
	 * This method handles the callback from Sign In With Twitter.
	 */
	public function actionCallback() {
		// TODO
	}
	
	/**
	 * This method handles the sign in in debug environments that skip twitter
	 */
	public function actionDebugCallback() {
		$twitter_id = "93370723";
		
		$user = User::model()->findOrCreate($twitter_id);
	}
}
<?php
class AuthController extends Controller {
	
	/**
	 * This action redirects the user to twitter to sign in. In the case
	 * we are in debug mode, it will simply redirect the user to the debug
	 * callback.
	 */
	public function actionSignInWithTwitter() {
		if(defined('YII_DEBUG')) {
			$this->redirect(array('/auth/DebugCallback'));
		} else {
			// TODO
		}
	}
	
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
		$twitter_id = '93370723';
		$auth_token = '93370723-3MlkNH3ChTxzf9U6wTDADcAO3sgtcgiObbEKhThg4';
		$auth_token_secret = 'kaoX8S03GVwqNRLmH0YVzJE5gc1DMo3XPU1Tn4J1o';
		
		$user = User::model()->findOrCreate($twitter_id);
		$user->auth_token = $auth_token;
		$user->auth_token_secret = $auth_token_secret;
		$user->save();
		
		ActiveUser::setActiveUser($user->user_id);
		
		$this->redirect(array('/site/dashboard'));
	}
	
	public function actionSignOut() {
		ActiveUser::clearActiveUser();
		
		$this->redirect(array('/site/index'));
	}
}
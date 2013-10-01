<?php
class AuthController extends Controller {
	
	/**
	 * This action redirects the user to twitter to sign in. In the case
	 * we are in debug mode, it will simply redirect the user to the debug
	 * callback.
	 */
	public function actionSignInWithTwitter() {
			
		if(YII_DEBUG) {
			$this->redirect(array('/auth/DebugCallback'));
		} else {
			// Get the twitter URL for redirect
			$redirect_url = TwitterUtils::getSignInUrl();
			
			$this->redirect($redirect_url);
		}
	}
	
	/**
	 * This method handles the callback from Sign In With Twitter.
	 */
	public function actionCallback() {
		// Turn the callback $_REQUEST data into credentials
		$token_creds = TwitterUtils::getLongTermCredentials();
		
		// In the event the user cancels, etc.
		if($token_creds == null) {
			$this->redirect(array('/site/index'));
		}
		
		// Validate tokens and get twitter_id
		$twitter_id = TwitterUtils::validateToken($token_creds['oauth_token'], $token_creds['oauth_token_secret']);
		
		if(empty($twitter_id)) {
			// Something went wrong
			$this->redirect(array('/site/index'));
		}
		
		$user = User::findOrCreate($twitter_id);
		
		// Set user tokens
		$user->auth_token = $token_creds['oauth_token'];
		$user->auth_token_secret = $token_creds['oauth_token_secret'];
		$user->save();
		
		UserSessionManager::initSession($user->user_id);
		
		$this->redirect(array('/site/dashboard'));
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
		
		UserSessionManager::initSession($user->user_id);
		
		$this->redirect(array('/site/dashboard'));
	}
	
	public function actionSignOut() {
		UserSessionManager::destroyCurrentSession();
		
		$this->redirect(array('/site/index'));
	}
}
<?php
class AuthController extends Controller {
	
	/**
	 * This action redirects the user to twitter to sign in. In the case
	 * we are in debug mode, it will simply redirect the user to the debug
	 * callback.
	 */
	public function actionSignInWithTwitter() {
		// Get the twitter URL for redirect
		$redirect_url = TwitterUtils::getSignInUrl();
			
		if(YII_DEBUG) {
			$this->redirect(array('/auth/DebugCallback'));
		} else {
			
			$this->redirect($redirect_url);
		}
	}
	
	/**
	 * This method handles the callback from Sign In With Twitter.
	 */
	public function actionCallback() {
		// Turn the callback $_REQUEST data into credentials
		$token_creds = TwitterUtils::getLongTermCredentials();
		
		// Validate tokens and get twitter_id
		$twitter_id = TwitterUtils::validateToken($token_creds['auth_token'], $token_creds['auth_token_secret']);
		
		if(empty($twitter_id)) {
			// Something went wrong
			$this->redirect(array('/site/index'));
		}
		
		$user = User::findOrCreate($twitter_id);
		
		// Set user tokens
		$user->auth_token = $token_creds['oauth_token'];
		$user->auth_token_secret = $token_creds['oauth_token_secret'];
		$user->save();
		
		ActiveUser::setActiveUser($user->user_id);
		
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
		
		ActiveUser::setActiveUser($user->user_id);
		
		$this->redirect(array('/site/dashboard'));
	}
	
	public function actionSignOut() {
		ActiveUser::clearActiveUser();
		
		$this->redirect(array('/site/index'));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
}
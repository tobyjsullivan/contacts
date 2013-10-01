<?php
class AjaxController extends Controller {
	public $layout = 'ajax';
	
	public function actionGetFollowerCount($twitter_handle) {
		$user_id = UserSessionManager::getCurrentUserId();
		// If no active user exists, throw an authorisation error
		if(!$user_id) {
			throw new CHttpException(401,'UNAUTHORIZED');
		}
		
		$followerCount = TwitterUtils::getFollowerCount($twitter_handle);
		$this->render('followerCount', array('followerCount' => $followerCount));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			$this->render('error', $error);
		}
	}
}
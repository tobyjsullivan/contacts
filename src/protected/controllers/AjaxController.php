<?php
class AjaxController extends Controller {
	public $layout = 'ajax';
	
	public function actionGetFollowerCount($twitter_handle) {
		$user_id = $this->requireActiveUser();
		if($user_id == null) {
			return;
		}
		
		$followerCount = TwitterUtils::getFollowerCount($twitter_handle);
		$this->render('followerCount', array('followerCount' => $followerCount));
	}

	/**
	 * This method handles fetching the active user id or redirecting to the
	 * index page if one is not set.
	 */
	protected function requireActiveUser() {
		$user_id = UserSessionManager::getCurrentUserId();
		// If no active user exists, redirect to index
		if($user_id == null) {
			$this->redirect(array('/site/index'));
			return null;
		}
	
		return $user_id;
	}
}
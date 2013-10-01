<?php

class SiteController extends Controller
{
	
	protected $showNav = true;
	
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// Redirect the user to their dashboard if they are already signed in
		$user_id = UserSessionManager::getCurrentUserId();
		if($user_id != null) {
			$this->redirect(array('/site/dashboard'));
		}
		
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}
	
	/**
	 * This is the action to display the user's main contact list
	 */
	public function actionDashboard() {
		$user_id = $this->requireActiveUser();
		if($user_id == null) {
			return;
		}
		
		$contacts = Contact::model()->findAll('owner_id=:owner_id', array(':owner_id'=>$user_id));
		
		$this->render('dashboard', array('contacts'=>$contacts));
	}
	
	/**
	 * This method handles fetching the active user id or redirecting to the
	 * index page if one is not set.
	 */
	private function requireActiveUser() {
		$user_id = UserSessionManager::getCurrentUserId();
		// If no active user exists, redirect to index
		if($user_id == null) {
			$this->redirect(array('/site/index'));
			return null;
		}
		
		return $user_id;
	}
	
	/**
	 * This is the action to display the AddContact form
	 */
	public function actionAdd() {
		$model=new ContactForm;
		if(isset($_POST['ContactForm'])) {
			
			$model->attributes=$_POST['ContactForm'];
			
			if($model->validate()) {
				$user_id = $this->requireActiveUser();
				if($user_id == null) {
					return;
				}
			
				$contact = new Contact;
				$contact->owner_id = $user_id;
				$contact->name = $_POST['ContactForm']['name'];
				$contact->phone = $_POST['ContactForm']['phone'];
				$contact->twitter = trim($_POST['ContactForm']['twitter'], "@");
				$contact->save();

				$this->redirect(array('/site/dashboard'));
			}
		}
		
		
		$this->pageTitle="New Contact";
		
		$this->render('add', array('model' => $model));
	}
	
	/**
	 * This is the action to display the EditContact form
	 */
	public function actionEdit($contact_id) {
		$user_id = $this->requireActiveUser();
		if($user_id == null) {
			return;
		}
		
		// Find the contact that matches the contact id AND is owned by the current user
		$contact = Contact::model()->find('contact_id=:contact_id AND owner_id=:owner_id', array(
				':contact_id'=>$contact_id,
				':owner_id'=>$user_id
		));

		if($contact == null) {
			$this->redirect(array('/site/dashboard'));
			return;
		}

		$model=new ContactForm;
		if(isset($_POST['ContactForm'])) {
				
			$model->attributes=$_POST['ContactForm'];
				
			if($model->validate()) {
				$contact->name = $_POST['ContactForm']['name'];
				$contact->phone = $_POST['ContactForm']['phone'];
				$contact->twitter = trim($_POST['ContactForm']['twitter'], "@");
				$contact->save();
		
				$this->redirect(array('/site/view', 'contact_id'=>$contact_id));
			}
		}

		$this->pageTitle="Edit Contact";
		
		$model->name = $contact->name;
		$model->phone = $contact->phone;
		$model->twitter = $contact->twitter;
		
		$this->render('edit', array('model' => $model, 'contact_id' => $contact_id));
	}
	
	public function actionDelete($contact_id) {
		$user_id = $this->requireActiveUser();
		if($user_id == null) {
			return;
		}
		
		// Find the contact that matches the contact id AND is owned by the current user
		$contact = Contact::model()->find('contact_id=:contact_id AND owner_id=:owner_id', array(
				':contact_id'=>$contact_id,
				':owner_id'=>$user_id
		));
		
		if($contact != null) {
			$contact->delete();
		}

		$this->redirect(array('/site/dashboard'));
	}
	
	/**
	 * This is the action to display a contact's extended details
	 */
	public function actionView($contact_id) {
		$user_id = $this->requireActiveUser();
		if($user_id == null) {
			return;
		}
		
		// Find the contact that matches the contact id AND is owned by the current user
		$contact = Contact::model()->find('contact_id=:contact_id AND owner_id=:owner_id', array(
				':contact_id'=>$contact_id,
				':owner_id'=>$user_id
				));
		
		if($contact == null) {
			$this->redirect(array('/site/dashboard'));
		}
		
		$followerCount = null;
		if(!empty($contact->twitter)) {
			$followerCount = TwitterUtils::getFollowerCount($contact->twitter);
		}
		
		$this->render('view', array('contact'=>$contact, 'followerCount'=>$followerCount));
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
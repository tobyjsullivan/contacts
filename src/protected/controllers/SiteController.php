<?php

class SiteController extends Controller
{
	public $layout = 'contacts';
	
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
		
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}
	
	/**
	 * This is the action to display the user's main contact list
	 */
	public function actionDashboard() {
		$this->render('dashboard');
	}
	
	/**
	 * This is the action to display the AddContact form
	 */
	public function actionAdd() {

		$this->pageTitle="New Contact";
		
		$model=new ContactForm;
		$this->render('add', array('model' => $model));
	}
	
	/**
	 * This is the action to display the EditContact form
	 */
	public function actionEdit() {

		$this->pageTitle="Edit Contact";
		
		$model=new ContactForm;
		$this->render('add', array('model' => $model));
	}
	
	/**
	 * This is the action to display a contact's extended details
	 */
	public function actionView() {
		$this->render('view');
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
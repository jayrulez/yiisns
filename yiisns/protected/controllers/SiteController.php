<?php

class SiteController extends Controller
{
	public function filters()
	{
		return array(
			'accessControl',
		);
	}
	
	public function accessRules()
	{
		return array(
			array(
				'deny',
				'actions'=>array('register, login'),
				'users'=>array('@'),
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		if(!Yii::app()->user->isGuest)
		{
			$this->redirect(array('/home'));
		}
		$this->render('index');
	}
	
	public function actionRegister()
	{
		$registrationForm = new RegistrationForm;
		
		if(($post = Yii::app()->request->getPost('RegistrationForm')) !== null)
		{
			$registrationForm->attributes = $post;
			
			if($registrationForm->process())
			{
				$loginForm = new LoginForm;
				$loginForm->username = $registrationForm->username;
				$loginForm->password = $registrationForm->password;
				
				if($loginForm->process())
				{
					$this->redirect(Yii::app()->homeUrl);
				}else{
					$this->redirect(Yii::app()->user->loginUrl);
				}
			}
		}
		
		$this->render('register', array(
			'form'=>$registrationForm,
		));
	}
	
	public function actionLogin()
	{
		$loginForm = new LoginForm;
		
		if(($post = Yii::app()->request->getPost('LoginForm')) !== null)
		{
			$loginForm->attributes = $post;
			
			if($loginForm->process())
			{
				$this->redirect(Yii::app()->homeUrl);
			}
		}
		
		$this->render('login', array(
			'form'=>$loginForm,
		));
	}
	
	public function actionLogout()
	{
		if(!Yii::app()->user->isGuest)
		{
			Yii::app()->user->logout();
		}
		
		$this->redirect(Yii::app()->homeUrl());
	}
}
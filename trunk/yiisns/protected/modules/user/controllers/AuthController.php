<?php

class AuthController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionLogin()
	{
		$form = new LoginForm;
		
		if(($post = Yii::app()->getRequest()->getPost('LoginForm')) !== null)
		{
			$form->attributes = $post;
			
			if($form->validate() && $form->login())
			{
				$this->redirect(Yii::app()->homeUrl);
			}
		}
		
		$this->render('login', array(
			'form'=>$form,
		));
	}

	public function actionLogout()
	{
		$this->render('logout');
	}

	public function actionRegister()
	{
		$this->render('register');
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}
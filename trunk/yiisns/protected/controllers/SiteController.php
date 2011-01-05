<?php

class SiteController extends Controller
{
	public function actionIndex()
	{
		if(!Yii::app()->getUser()->getIsGuest())
		{
			$this->redirect(array('/aspect/index'));
		}else{
			$this->render('index');
		}
	}

	public function actionError()
	{
	    if($error=Yii::app()->getErrorHandler()->getError())
	    {
	    	if(Yii::app()->getRequest()->isAjaxRequest)
			{
	    		echo $error['message'];
	    	}else{
	        	$this->render('error', $error);
			}
	    }
	}
	
	public function actionRegister()
	{
		if(!Yii::app()->getUser()->getIsGuest())
		{
			$this->redirect(array('/aspect/index'));
		}else{
			$registrationForm = new RegistrationForm;
			
			if(($post = Yii::app()->getRequest()->getPost('RegistrationForm')) !== null)
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
						$this->redirect(Yii::app()->getUser()->loginUrl);
					}
				}
			}
			
			$this->render('register', array(
				'form'=>$registrationForm,
			));
		}
	}
	
	public function actionLogin()
	{
		if(!Yii::app()->getUser()->getIsGuest())
		{
			$this->redirect(array('/aspect/index'));
		}else{
			$loginForm = new LoginForm;
			
			if(($post = Yii::app()->getRequest()->getPost('LoginForm')) !== null)
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
	}
	
	public function actionLogout()
	{
		if(!Yii::app()->getUser()->getIsGuest())
		{
			Yii::app()->getUser()->logout();
		}
		
		$this->redirect(Yii::app()->homeUrl);
	}
}
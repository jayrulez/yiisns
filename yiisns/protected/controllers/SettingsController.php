<?php

class SettingsController extends Controller
{
	public $defaultAction = 'account';
	
	public function accessRules()
	{
		return array(
			array(
				'allow',
				'actions'=>array(
					'account',
				),
				'users'=>array('@'),
			),
			array(
				'deny',
				'actions'=>array(
					'account',
				),
				'users'=>array('*'),
			),
		);
	}
	
	public function actionAccount()
	{	
		$user = $this->loadUser(Yii::app()->getUser()->getModel()->id);
		
		$this->render('account', array(
			'user'=>$user,
		));
	}
	
	public function loadUser($userId)
	{
		$user = User::model()->findByPk($userId);
			
		if($user === null)
		{
			throw new CHttpException(404,Yii::t('application','The requested page does not exist.'));
		}else{
			return $user;
		}
	}
}
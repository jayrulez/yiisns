<?php

class UserController extends Controller
{
	public $defaultAction = 'view';
	
	public function accessRules()
	{
		return array(
			array(
				'allow',
				'actions'=>array(
					'view',
				),
				'users'=>array('@'),
			),
			array(
				'deny',
				'actions'=>array(
					'view',
				),
				'users'=>array('*'),
			),
		);
	}
	
	public function actionView()
	{	
		$user = $this->loadUser(($userId = Yii::app()->getRequest()->getParam('id')) !== null ? $userId : Yii::app()->getUser()->getModel()->id);
		
		$this->render('view', array(
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
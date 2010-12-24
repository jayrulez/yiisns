<?php

class ProfileController extends Controller
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
		$userId = Yii::app()->request->getParam('id', Yii::app()->user->getId());
		
		$user = User::model()->findByPk($userId);
		
		if($user === null)
		{
			throw new CHttpException(404, Yii::t('application', 'The requested page was not found.'));
		}
		
		$this->render('view', array(
			'user'=>$user,
		));
	}
}
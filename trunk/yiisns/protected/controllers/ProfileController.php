<?php

class ProfileController extends Controller
{
	public $defaultAction = 'view';
	
	public function accessRules()
	{
		return array();
	}
	
	public function actionView()
	{
		$userId = Yii::app()->request->getParam('user_id', Yii::app()->user->getId());
		
		$user = User::model()->findByPk($userId);
		
		if($user === null)
		{
			throw new CHttpException(404, Yii::t('application', 'The requested page was not found.'));
		}
		
		$this->render('', array(
		
		));
	}
}
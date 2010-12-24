<?php

class SearchController extends Controller
{
	public function accessRules()
	{
		return array();
	}
	
	public function actionIndex()
	{
		$results = array();
		
		$criteria = new CDbCriteria;
		$criteria->addSearchCondition('username', Yii::app()->request->getParam('q'));
		$users = User::model()->findAll($criteria);
		if(count($users))
		{
			$results['users'] = $users;
		}
		
		$this->render('index', array(
			'results'=>$results,
			'q'=>Yii::app()->request->getParam('q'),
		));
	}
}
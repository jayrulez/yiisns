<?php

class HomeController extends Controller
{
	public function accessRules()
	{
		return array(
			array(
				'allow',
				'actions'=>array(
					'index',
				),
				'users'=>array('@'),
			),
			array(
				'deny',
				'actions'=>array(
					'index',
				),
				'users'=>array('*'),
			),
		);
	}
	
	public function actionIndex()
	{
		$user = Yii::app()->user->getModel();
		
		Yii::app()->user->setReturnUrl(Yii::app()->request->getUrl());
		
	    $this->render('index', array(
			'user'=>$user,
		));
	}
}
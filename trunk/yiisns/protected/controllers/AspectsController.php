<?php

class AspectsController extends Controller
{	
	public function accessRules()
	{
		return array(
			array(
				'allow',
				'actions'=>array(
					'index','create','delete','view',
				),
				'users'=>array('@'),
			),
			array(
				'deny',
				'actions'=>array(
					'index','create','delete','view',
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
	
	public function actionCreate()
	{
		$aspect = new Aspect;
		
		if(($post = Yii::app()->request->getPost('Aspect')) !== null)
		{
			$aspect->attributes = $post;
			$aspect->user_id = Yii::app()->user->getId();
			
			if($aspect->save())
			{
				$this->redirect(array('/aspects/view', 'id'=>$aspect->id));
			}
		}
		
		$this->render('create', array(
			'model'=>$aspect,
		));
	}
	
	public function actionDelete()
	{
		$aspect = Aspect::model()->findByAttributes(array(
			'id'=>Yii::app()->request->getPost('id'),
			'user_id'=>Yii::app()->user->getId(),
		));
		
		if($aspect === null)
		{
			throw new CHttpException(403, Yii::t('application', 'You do not have permission to delete this aspect.'));
		}
		
		$aspect->delete();
		
		$this->redirect(Yii::app()->user->returnUrl);
	}
	
	public function actionView()
	{
		$aspect = Aspect::model()->findByAttributes(array(
			'id'=>Yii::app()->request->getParam('id'),
		));
		
		if($aspect === null || Yii::app()->user->getId() !== $aspect->user_id)
		{
			throw new CHttpException(404, Yii::t('application', 'This aspect is not available.'));
		}
		
		Yii::app()->user->setReturnUrl(Yii::app()->request->getUrl());
		
		$this->render('view', array(
			'aspect'=>$aspect,
		));
	}
	
	public function actionUpdate()
	{
		$this->render('update');
	}
}
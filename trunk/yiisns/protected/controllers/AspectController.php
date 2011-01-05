<?php

class AspectController extends Controller
{
	public function accessRules()
	{
		return array(
			array(
				'allow',
				'actions'=>array(
					'index','create','update','view','delete','manage',
				),
				'users'=>array('@'),
			),
			array(
				'deny',
				'actions'=>array(
					'index','create','update','view','delete','manage',
				),
				'users'=>array('*'),
			),
		);
	}
	
	public function actionIndex()
	{
		$user = Yii::app()->getUser()->getModel();
		
		$this->render('index', array(
			'user'=>$user,
		));
	}
	
	public function actionCreate()
	{
		$aspect = new Aspect;
		
		if(($post=Yii::app()->getRequest()->getPost('Aspect')) !== null)
		{
			$aspect->attributes = $post;
			$aspect->user_id = Yii::app()->getUser()->getModel()->id;
			
			if($aspect->save())
			{
				$this->redirect($aspect->getUrl());
			}
		}
		
		$this->render('create', array(
			'model'=>$aspect,
		));
	}
	
	public function actionUpdate()
	{
		$aspect = $this->loadAspect(Yii::app()->getRequest()->getParam('id'));
		
		if(($post=Yii::app()->getRequest()->getPost('Aspect')) !== null)
		{
			$aspect->attributes = $post;
			
			if($aspect->save())
			{
				$this->redirect($aspect->getUrl());
			}
		}
		
		$this->render('update', array(
			'model'=>$aspect,
		));
	}
	
	public function actionView()
	{
		$aspect = $this->loadAspect(Yii::app()->getRequest()->getParam('id'));
		
		$this->render('view', array(
			'aspect'=>$aspect,
		));
	}
	
	public function actionDelete()
	{
		$aspect = $this->loadAspect(Yii::app()->getRequest()->getParam('id'));
		$aspect->delete();
		
		$this->redirect(array('/aspect/index'));
	}
	
	public function actionManage()
	{
		$this->render('manage', array(
			'user'=>Yii::app()->getUser()->getModel(),
		));
	}
	
	public function loadAspect($aspectId)
	{
		$aspect = Aspect::model()->findByPk($aspectId);
			
		if($aspect === null || $aspect->user_id !== Yii::app()->getUser()->getModel()->id)
		{
			throw new CHttpException(404,Yii::t('application','The requested page does not exist.'));
		}else{
			return $aspect;
		}
	}
}
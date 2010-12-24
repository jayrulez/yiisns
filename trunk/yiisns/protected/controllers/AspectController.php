<?php

class AspectController extends Controller
{
	public function accessRules()
	{
		return array();
	}
	
	public function actionIndex()
	{		
		$user = Yii::app()->user->getModel();
		
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
				$this->redirect(array('/aspect/view', 'id'=>$aspect->id));
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
			throw new CHttpException(404, Yii::t('application', 'The requested page was not found.'));
		}
		
		$aspect->delete();
		
		$this->redirect(array('/aspect'));
	}
	
	public function actionView()
	{
		$user = Yii::app()->user->getModel();
		
		$aspect = Aspect::model()->findByAttributes(array(
			'id'=>Yii::app()->request->getParam('id'),
		));
		
		if($aspect === null)
		{
			throw new CHttpException(404, Yii::t('application', 'The requested page was not found.'));
		}
		
		if($user->id !== $aspect->user_id)
		{
			throw new CHttpException(401, Yii::t('application', 'You are not authorized to view this aspect.'));
		}
		
		$this->render('view', array(
			'aspect'=>$aspect,
		));
	}
	
	public function actionManage()
	{
	
	}
}
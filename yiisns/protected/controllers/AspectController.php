<?php

class AspectController extends Controller
{
	public function filters()
	{
		return array(
			'accessControl',
		);
	}
	
	public function accessRules()
	{
		return array(
			array(
				'deny',
				'actions'=>array('*'),
				'users'=>array('?'),
			),
		);
	}
	
	public function actionIndex()
	{
		$user = Yii::app()->user->getModel();
		
		$dataProvider = new CActiveDataProvider('Post', array(
			'criteria'=>array(
				'order'=>'t.create_time DESC',
				'with'=>array(
					'user',
				),
			),
			/*'pagination'=>array(
				'pageSize'=>20,
			),*/
		));
		
		// $posts = $dataProvider->getData();
		
	    $this->render('index');
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
			'aspect'=>$aspect,
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
		$aspect = Aspect::model()->findByAttributes(array(
			'id'=>Yii::app()->request->getParam('id'),
			'user_id'=>Yii::app()->user->getId(),
		));
		
		if($aspect === null)
		{
			throw new CHttpException(404, Yii::t('application', 'The requested page was not found.'));
		}
		
		$this->render('view', array(
			'aspect'=>$aspect,
		));
	}
}
<?php

class AspectController extends Controller
{
	public function actionIndex()
	{
		$user = Yii::app()->user->getModel();
		
		$criteria = new CDbCriteria;
		$criteria->condition = 'user_id=:user_id OR id IN(:range)';
		
		$aspects = Aspects::model()->findAllByAttributes(array(
			'user_id'=>$user->id,
		));
		
		$contacts = array();
		
		foreach($aspects as $aspect)
		{
		
		}
		
		$criteria->params = array(
			':user_id'=>$user->id,
			':range'=>array(1,2,3),
		);
		
		$posts = Post::model()->find($criteria);
		
	    $this->render('index', array(
			'posts'=>$posts,
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
			
			}
		}
		
		$this->render('create', array(
			'aspect'=>$aspect,
		));
	}
	
	public function actionDelete()
	{
	
	}
	
	public function actionView()
	{
		$aspect = Aspect::model()->findByAttributes(array(
			'id'=>Yii::app()->request->getParam('id');
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
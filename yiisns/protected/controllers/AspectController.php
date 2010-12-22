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
		/*$dataProvider = new CActiveDataProvider('Post', array(
			'criteria'=>array(
				'order'=>'t.create_time DESC',
				'with'=>array(
					'user',
				),
			),
			'pagination'=>array(
				'pageSize'=>20,
			),
		));*/
		
		// $posts = $dataProvider->getData();
		
		$posts = Post::model()->findAllBySql("SELECT DISTINCT p . * 
			FROM post AS p
			INNER JOIN (
				SELECT p_a . * FROM post_aspect AS p_a
				INNER JOIN (
					SELECT contact_aspect . * 
					FROM aspect
					INNER JOIN contact_aspect ON aspect.id = contact_aspect.aspect_id
					WHERE contact_aspect.user_id =:user_id
					OR contact_aspect.contact_id =:user_id
				) AS c_a ON c_a.aspect_id = p_a.aspect_id
			) AS p_a ON p.id = p_a.post_id", array(
			':user_id'=>Yii::app()->user->getId(),
		));
		
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
		
		if(!$user->canSeeAspect($aspect->id))
		{
			throw new CHttpException(401, Yii::t('application', 'You are not authorized to view this aspect.'));
		}
		
		$posts = Post::model()->findAllBySql("SELECT DISTINCT p . * 
			FROM post AS p
			INNER JOIN (
				SELECT p_a . * FROM post_aspect AS p_a
				INNER JOIN (
					SELECT contact_aspect . * 
					FROM aspect
					INNER JOIN contact_aspect ON aspect.id = contact_aspect.aspect_id
					WHERE contact_aspect.user_id =:user_id
					OR contact_aspect.contact_id =:user_id
				) AS c_a ON c_a.aspect_id = p_a.aspect_id
				WHERE c_a.aspect_id=:aspect_id
			) AS p_a ON p.id = p_a.post_id", array(
			':user_id'=>$user->id,
			':aspect_id'=>$aspect->id,
		));
		
		$this->render('view', array(
			'aspect'=>$aspect,
			'posts'=>$posts,
		));
	}
}
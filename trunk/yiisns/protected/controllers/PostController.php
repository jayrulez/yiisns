<?php

class PostController extends Controller
{
	public $defaultAction = 'view';
	
	public function accessRules()
	{
		return array(
			array(
				'allow',
				'actions'=>array(
					'create','view','delete',
				),
				'users'=>array('@'),
			),
			array(
				'deny',
				'actions'=>array(
					'create','view','delete',
				),
				'users'=>array('*'),
			),
		);
	}
	
	public function actionCreate()
	{
		$post = new Post;
		
		if(($_post=Yii::app()->getRequest()->getPost('Post')) !== null)
		{
			$post->attributes = $_post;
			$post->user_id = Yii::app()->getUser()->getModel()->id;
			
			$connection  = $post->dbConnection;
			$transaction = $connection->beginTransaction();
			try
			{
				$post->save();
				
				if(($aspectIds = Yii::app()->getRequest()->getPost('aspectsIds')) !== null)
				{
					$post->addToAspects($aspectIds, $connection);
				}
				
				$transaction->commit();
			}catch(Exception $e)
			{
				$transaction->rollBack();
				throw new CException($e->getMessage());
			}
			
			$this->redirect($post->getUrl());
		}
		
		$this->redirect(Yii::app()->getUser()->getReturnUrl());
	}
	
	public function actionView()
	{
		$post = $this->loadPost(Yii::app()->getRequest()->getParam('id'));
		
		$this->render('view', array(
			'post'=>$post,
		));
	}
	
	public function actionDelete()
	{
		$post = $this->loadPost(Yii::app()->getRequest()->getParam('id'));
		
		if($post->user_id !== Yii::app()->getUser()->getModel()->id)
		{
			throw new CHttpException(401, Yii::t('application','You do not have permission to delete this post.'));
		}else{
			$post->delete();
			
			$this->redirect(array('/aspect/index'));
		}
	}
	
	public function loadPost($postId)
	{
		$post = Post::model()->findByPk($postId);
			
		if($post === null)
		{
			throw new CHttpException(404,Yii::t('application','The requested page does not exist.'));
		}else{
			return $post;
		}
	}
}
<?php

class CommentController extends Controller
{
	public function accessRules()
	{
		return array(
			array(
				'allow',
				'actions'=>array(
					'create','delete',
				),
				'users'=>array('@'),
			),
			array(
				'deny',
				'actions'=>array(
					'create','delete',
				),
				'users'=>array('*'),
			),
		);
	}
	
	public function actionIndex()
	{
		$this->redirect(Yii::app()->homeUrl);
	}
	
	public function actionCreate()
	{
		$comment = new Comment;
		$user = Yii::app()->getUser()->getModel();
		
		if(($post=Yii::app()->getRequest()->getPost('Comment')) !== null)
		{
			$comment->attributes = $post;
			$comment->user_id = $user->id;
			
			if(!$user->canSeePost($comment->post_id))
			{
				throw new CHttpException(401, Yii::t('application', 'You cannot comment on this post.'));
			}
			
			if($comment->save())
			{
				$this->redirect($comment->post->getUrl());
			}
		}
		
		$this->render('create', array(
			'model'=>$comment,
		));
	}
	
	public function actionDelete()
	{
		$comment = $this->loadComment(Yii::app()->getRequest()->getParam('id'));
		
		if(!($comment->user_id === Yii::app()->getUser()->getModel()->id || $comment->post->user_id === Yii::app()->getUser()->getModel()->id))
		{
			throw new CHttpException(401, Yii::t('application','You do not have permission delete this comment.'));
		}else{
			$comment->delete();
			$this->redirect($comment->post->getUrl());
		}
	}
	
	public function loadComment($commentId)
	{
		$comment = Comment::model()->findByPk($commentId);
			
		if($comment === null)
		{
			throw new CHttpException(404,Yii::t('application','The requested page does not exist.'));
		}else{
			return $comment;
		}
	}
}
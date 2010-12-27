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
		$this->redirect(Yii::app()->user->returnUrl);
	}
	
	public function actionCreate()
	{
		$comment = new Comment;
		
		if(($post = Yii::app()->request->getPost('Comment')) !== null)
		{
			$comment->attributes = $post;
			
			if(($user=Yii::app()->user->getModel()) === null || !$user->canCommentOnPost($comment->post_id))
			{
				throw new CHttpException(401, Yii::t('application','You cannot comment on this post.'));
			}else{
				$comment->user_id = $user->id;
				
				if($comment->save())
				{
					$this->redirect(array('/post/view', 'id'=>$comment->post_id));
				}else{
					//error, do something, redirect for now
					$this->redirect(Yii::app()->user->returnUrl);
				}
			}
		}else{
			$this->redirect(Yii::app()->user->returnUrl);
		}
	}
	
	public function actionDelete()
	{
	
	}
}
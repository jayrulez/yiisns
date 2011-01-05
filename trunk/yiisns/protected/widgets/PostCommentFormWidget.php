<?php

class PostCommentFormWidget extends CWidget
{	
	public $postId = array();
	
	public function init()
	{
	}
	
	public function run()
	{
		if(($user=Yii::app()->user->getModel()) === null || !$user->canSeePost($this->postId))
		{
			return;
		}
		$this->render('postCommentForm', array(
			'model'=>new Comment,
			'postId'=>$this->postId,
			'user'=>$user,
		));
	}
}
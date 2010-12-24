<?php

class PostFormWidget extends CWidget
{	
	public $aspectIds = array();
	
	public function init()
	{
	}
	
	public function run()
	{
		Yii::app()->user->setReturnUrl(Yii::app()->request->getUrl());
		
		$this->render('postForm', array(
			'model'=>new Post,
		));
	}
}
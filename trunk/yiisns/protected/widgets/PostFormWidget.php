<?php

class PostFormWidget extends CWidget
{	
	public $aspectIds = array();
	
	public function init()
	{
		Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/postForm.css');
	}
	
	public function run()
	{
		$this->render('postForm', array(
			'model'=>new Post,
		));
	}
}
<?php

class Controller extends CController
{
	public $layout='//layouts/main';
	
	public function filters()
	{
		return array(
			'accessControl',
		);
	}
	
	public function accessRules()
	{
		return array();
	}
	
	public function init()
	{
		parent::init();
	}
	
	public function getCurrentUser()
	{
		return Yii::app()->user->getModel();
	}
}
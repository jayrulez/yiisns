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
}
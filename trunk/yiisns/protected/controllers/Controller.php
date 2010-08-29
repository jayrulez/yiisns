<?php

abstract class Controller extends CController
{
	public $layout='//layouts/main';

	public $breadcrumbs=array();
	
	public function init()
	{
		parent::init();
	}
}
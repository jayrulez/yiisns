<?php

class PostFormWidget extends CWidget
{	
	public $aspect;
	
	public function init()
	{
	}
	
	public function run()
	{
		$this->render('postForm');
	}
}
<?php

class PostStreamWidget extends CWidget
{	
	public $aspect;
	
	public function init()
	{
	}
	
	public function run()
	{
		$this->render('postStream');
	}
}
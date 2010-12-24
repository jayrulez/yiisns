<?php

class PostFormWidget extends CWidget
{	
	public $aspectId = null;
	
	public function init()
	{
	}
	
	public function run()
	{
		$this->render('postForm', array(
			'model'=>new Post,
		));
	}
}
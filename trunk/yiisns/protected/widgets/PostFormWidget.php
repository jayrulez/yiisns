<?php

class PostFormWidget extends CWidget
{	
	public $aspectIds = array();
	
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
<?php

class PostStreamWidget extends CWidget
{	
	public $aspectId;
	
	public function init()
	{
	}
	
	public function run()
	{
		$posts = array();
		
		$this->render('postStream', array(
			'posts'=>$posts,
		));
	}
}
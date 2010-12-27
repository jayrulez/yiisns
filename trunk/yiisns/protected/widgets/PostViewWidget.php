<?php

class PostViewWidget extends CWidget
{	
	public $post = null;
	
	public function init()
	{
	}
	
	public function run()
	{
		if($this->post === null)
		{
			return;
		}
		
		$this->render('postView', array(
			'post'=>$this->post,
		));
	}
}
<?php

class FlashMessengerWidget extends CWidget
{
	public $categories = array();
	
	public function init()
	{
	}
	
	public function run()
	{
		if(!is_array($this->categories))
		{
			return;
		}
		
		$this->render('flashMessenger', array(
			'categories'=>$this->categories,
		));
	}
}
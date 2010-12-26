<?php

class UserIdentityWidget extends CWidget
{	
	public $user = null;
	
	public $viewerId = null;
	
	public function init()
	{
	}
	
	public function run()
	{
		if($this->user === null)
		{
			return;
		}
		$this->render('userIdentity', array(
			'user'=>$this->user,
			'viewerId'=>$this->viewerId,
		));
	}
}
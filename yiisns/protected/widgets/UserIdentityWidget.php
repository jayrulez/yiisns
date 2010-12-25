<?php

class UserIdentityWidget extends CWidget
{	
	public $userId = null;
	
	public function init()
	{
	}
	
	public function run()
	{		
		$this->render('userIdentity');
	}
}
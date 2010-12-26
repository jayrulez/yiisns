<?php

class UserIdentityWidget extends CWidget
{	
	public $userId = null;
	
	public $viewerId = null;
	
	public function init()
	{
	}
	
	public function run()
	{
		$user = User::model()->findByPk($this->userId);
		if($user === null)
		{
			return;
		}
		$this->render('userIdentity', array(
			'user'=>$user,
			'viewerId'=>$this->viewerId,
		));
	}
}
<?php

class WebUser extends CWebUser
{
	public $allowAutoLogin = true;
	
	public $loginUrl = array('/user/auth/login');
	
	public $registerUrl = array('/user/auth/register');
	
	public $identityClass = 'UserIdentity';
	
	public function init()
	{
		parent::init();
	}
	
	public function getIdentityInstance($username=null, $password=null)
	{
		if(empty($this->identityClass))
		{
			throw new CException(Yii::t('application', 'Property Webuser.identityClass must be specified.'));
		}
	
		$className = Yii::import($this->identityClass);
		
		return new $className($username, $password);
	}
}
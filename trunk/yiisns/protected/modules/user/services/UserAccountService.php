<?php

Yii::import('lib.service.ActiveRecordService');

class UserAccountService extends ActiveRecordService
{
	const AUTOLOGIN_DURATION = 2592000;
	
	public function modelClass()
	{
		return 'User';
	}
	
	public function login($params)
	{
		$this->getResult()->reset();
		
		$username = $this->getParam($params, 'username');
		$password = $this->getParam($params, 'password');
		
		$identity = Yii::app()->getUser()->getIdentityInstance($username, $password);
		
		$identity->authenticate();
		
		if($identity->errorCode === $identity::ERROR_NONE)
		{
			$duration = isset($params['rememberMe']) && $params['rememberMe'] ? self::AUTOLOGIN_DURATION : 0;
			
			Yii::app()->getUser()->login($identity, $duration);
			
			$this->getResult()->success();
			
			return true;
		}
		
		$this->getResult()->fail(ServiceResult::ERROR_SERVICE_ERROR, $identity->errorMessage);
		
		return false;
	}
}
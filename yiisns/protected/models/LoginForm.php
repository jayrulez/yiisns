<?php

class LoginForm extends CFormModel
{
	public $username;
	public $password; 
	public $autologin;

	public function rules()
	{
		return array(
			array('username, password', 'required'),
			array('autologin','boolean'),
		);
	}
	
	public function beforeValidate()
	{
		if(parent::beforeValidate())
		{
			$this->username = strtolower($this->username);
			return true;
		}
		return false;
	}
	
	public function process()
	{
		$this->validate();
		
		if(!$this->hasErrors())
		{
			$userIdentity = Yii::app()->user->getIdentityInstance($this->username, $this->password);
			
			if(!$userIdentity->authenticate())
			{
				if($userIdentity->errorCode === $userIdentity::ERROR_USERNAME_INVALID)
				{
					$this->addError('username', Yii::t('application', 'Username is invalid.'));
				}else if($userIdentity->errorCode === $userIdentity::ERROR_PASSWORD_INVALID)
				{
					$this->addError('password', Yii::t('application', 'Password is invalid.'));
				}else{
					$this->addError('username', Yii::t('application', 'We are unable to access your account at this time.'));
				}
				return false;
			}
			
			$period = 3600*24*7; // 7 days
			$duration = $this->autologin ? $period : 0;
			
			Yii::app()->user->login($userIdentity, $duration);
			return true;
		}
		return false;
	}
	
	public function attributeLabels()
	{
		return array(
			'username'=>Yii::t('application', 'Username'),
			'password'=>Yii::t('application', 'Password'),
			'autologin'=>Yii::t('application', 'Keep me logged in'),
		);
	}
}
<?php

class LoginForm extends CFormModel
{
	const AUTOLOGIN_DURATION = 2592000;
	
	public $username;
	public $password;
	public $autologin;
	private $_identity;
	
	public function rules()
	{
		return array(
			array('username, password', 'required'),
			array('autologin', 'boolean'),
			array('password', 'authenticate', 'skipOnError'=>true),
		);
	}

	public function attributeLabels()
	{
		return array(
			'autologin'=>Yii::t('application','Remember me next time'),
		);
	}

	public function authenticate($attribute, $params)
	{
		$identity = Yii::app()->getUser()->getIdentityInstance($this->username, $this->password);
		
		if(!$identity->authenticate())
		{
			if($identity->errorCode === $identity::ERROR_USERNAME_INVALID)
			{
				$this->addError('username', $identity->errorMessage);
			}else if($identity->errorCode === $identity::ERROR_PASSWORD_INVALID)
			{
				$this->addError('password', $identity->errorMessage);
			}
		}
		$this->_identity = $identity;
	}
	
	public function login()
	{
		$identity = $this->_identity;
		
		if($identity === null)
		{
			$identity = Yii::app()->getUser()->getIdentityInstance($this->username, $this->password);
			
			$identity->authenticate();
		}
		
		if($identity->errorCode === $identity::ERROR_NONE)
		{
			$duration = $this->autologin ? self::AUTOLOGIN_DURATION : 0;
			
			Yii::app()->getUser()->login($identity, $duration);
			
			return true;
		}
		return false;
	}
}

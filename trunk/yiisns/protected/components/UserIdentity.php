<?php

class UserIdentity extends CUserIdentity
{
	public function authenticate()
	{
		$users=array(
			// username => password
			'demo'=>'demo',
			'admin'=>'admin',
		);
		if(!isset($users[$this->username]))
		{
			$this->errorMessage = Yii::t('application','Username is invalid.');
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		}else if($users[$this->username]!==$this->password)
		{
			$this->errorMessage = Yii::t('application','Password is incorrect.');
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		}else{
			$this->errorCode=self::ERROR_NONE;
		}
		return !$this->errorCode;
	}
}
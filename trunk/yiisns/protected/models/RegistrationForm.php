<?php

class RegistrationForm extends CFormModel
{
	public $username;
	public $password; 

	public function rules()
	{
		return array(
			array('username, password', 'required'),
			array('username, password', 'length', 'min'=>5, 'max'=>32),
			array('username', 'unique', 'className'=>'User', 'attributeName'=>'username'),
		);
	}
	
	public function process()
	{
		$this->validate();
		
		if(!$this->hasErrors())
		{
			$user = new User;
			$user->username = $this->username;
			$user->password = $this->password;
			
			if(!$user->save())
			{
				foreach($user->getErrors() as $errors)
				{
					foreach($errors as $field => $message)
					{
						$this->addError($field, $message);
					}
				}
				return false;
			}
			return true;
		}
		return false;
	}
	
	public function attributeLabels()
	{
		return array(
			'username' => Yii::t('application', 'Username'),
			'password' => Yii::t('application', 'Password'),
		);
	}
}
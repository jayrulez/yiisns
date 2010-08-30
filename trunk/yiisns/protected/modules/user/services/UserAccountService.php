<?php

Yii::import('lib.service.ActiveRecordService');

class UserAccountService extends ActiveRecordService
{	
	public function modelClass()
	{
		return 'User';
	}
	
	public function login($params)
	{
		$form = new LoginForm;
		
		$form->attributes = $params;
		
		if($form->validate() && $form->login())
		{
			$this->getResult()->success();
		}else{
			$this->getResult()->fail(ServiceResult::ERROR_SERVICE_ERROR, $form->getErrors());
		}
		
		$this->getResult()->setReturnData($form);
		
		return $this->getResult()->getIsSuccessful();
	}
}
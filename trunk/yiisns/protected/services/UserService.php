<?php

Yii::import('lib.service.ActiveRecordService');

class UserService extends ActiveRecordService
{
	public function modelClass()
	{
		return 'User';
	}
}
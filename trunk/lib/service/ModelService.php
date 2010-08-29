<?php

Yii::import('lib.service.BaseService');

abstract class ModelService extends BaseService
{
	public function init()
	{
		parent::init();
		
		$modelClass = $this->modelClass();
		
		if(empty($modelClass) || $modelClass = null)
		{
			throw new CException(Yii::t('application','Method "{class}.modelClass" must return the name of a class.', array(
				'{class}'=>get_class($this),
			)));
		}
		Yii::import($modelClass);
	}
	
	abstract public function modelClass();
}
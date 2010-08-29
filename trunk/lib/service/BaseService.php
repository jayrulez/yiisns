<?php

Yii::import('lib.service.ServiceResult');

abstract class BaseService extends CComponent
{
	protected $result;
	
	public function __construct()
	{
		$this->result = new ServiceResult(get_class($this));
		$this->init();
	}
	
	public function __call($method, $parameters)
	{
		throw new CException(Yii::t('application','Service method "{class}.{method}" is not defined.', array(
			'{method}' => $method,
			'{class}'  => get_class($this),
		)));
	}
	
	public function init()
	{		
	}
	
	public function getParam($params, $name, $defaultValue = null)
	{
		if(!is_array($params))
		{
			throw new CException(Yii::t('application','The arguement "params" must be an array.'));
		}
		
		return isset($params[$name]) ? $params[$name] : $defaultValue;
	}
	
	public function getResult()
	{
		return $this->result;
	}
}
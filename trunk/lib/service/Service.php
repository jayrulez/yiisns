<?php

class Service extends CComponent
{
	protected $module;
	
	const COMPONENT_SEPARATOR = '/';
	
	public function __construct($moduleId=null)
	{
		$this->module = self::getModule($moduleId);
		$this->init();
	}
	
	public function __get($name)
	{
		if(property_exists($this, $name))
		{
			return parent::__get($name);
		}else{
			$serviceClass = $name;
			
			if($this->module !== null)
			{
				$serviceClass = $this->module->importService($serviceClass);
				if($serviceClass === null)
				{
					throw new CException(Yii::t('application','The path "{servicesPath}" is not valid.', array(
						'{servicesPath}'=>$this->module->getServicesPath(),
					)));
				}
			}else{
				$serviceClass = Yii::import('application.services.'.$serviceClass);
			}
			
			$service = new $serviceClass;
			
			if($service instanceof BaseService)
			{
				return $service;
			}else{
				throw new CException(Yii::t('application','Service "{serviceClass}" must extend "BaseService" or it\'s children.', array(
					'{serviceClass}'=>$serviceClass,
				)));
			}
		}
	}
	
	public function init()
	{
	}
	
	protected function getModule($moduleId)
	{
		if($moduleId !== null)
		{
			if(is_string($moduleId))
			{
				$module = Yii::app()->getModule($moduleId);
				
				if($module === null)
				{
					throw new CException(Yii::t('application','The module "{moduleId}" cannot be found.', array(
						'{moduleId}'=>$moduleId,
					)));
				}
			}
			
			if($module !== null && !$module instanceof WebModule)
			{
				throw new CException(Yii::t('application','Your module "{moduleClass}" must extend WebModule or one of it\'s children.', array(
					'{moduleClass}'=>get_class($module),
				)));
			}
		}else{
			$module = null;
		}
		return $module;
	}
	
	public static function _($moduleId=null)
	{
		return new self($moduleId);
	}
	
	public static function get($serviceTag, $parameters=array())
	{
		if(!is_array($serviceTag))
		{
			throw new CException(Yii::t('application','Service tag must be an array.'));
		}
		
		$componentsNum = count($serviceTag);
		
		if($componentsNum === 3 || $componentsNum === 2)
		{
			if($componentsNum === 3)
			{
				$moduleId = $serviceTag[0];
				$serviceClass = $serviceTag[1];
				$serviceMethod = $serviceTag[2];
			}else{
				$moduleId = null;
				$serviceClass = $serviceTag[0];
				$serviceMethod = $serviceTag[1];
			}
		}else{
			throw new CException(Yii::t('application','Service tag must be in the format array("module","class","method") or array("class","method").'));
		}
		
		$service = self::_($moduleId)->{$serviceClass};
		
		$functionValue = call_user_func(array($service, $serviceMethod), $parameters);
		
		$service->getResult()->setFunctionValue($functionValue);
		
		return $service;
	}
	
	public static function getResult($serviceTag, $parameters = array())
	{
		return self::get($serviceTag, $parameters)->getResult();
	}
}
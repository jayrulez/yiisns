<?php

class ServiceResult extends CComponent
{
	const ERROR_NONE           = 0;
	const ERROR_PARAMS_INVALID = 1;
	const ERROR_SERVICE_ERROR  = 2;
	
	const FAILURE    = 0;
	const SUCCESS    = 1;
	
	private $_errors = array();
	private $_serviceId;
	private $_returnCode;
	private $_errorCode;
	private $_returnData;
	private $_functionValue;
	
	public function __construct($serviceId, $returnCode = self::SUCCESS, $errorCode = self::ERROR_NONE, $errors=array())
	{
		$this->setServiceId($serviceId);
		
		$this->_returnCode = $returnCode;
		$this->_errorCode = $errorCode;
		
		$this->addErrors($errors);
	}
	
	public function reset()
	{
		$this->_errors = array();
		$this->_serviceId = null;
		$this->_returnCode = self::SUCCESS;
		$this->_errorCode = self::ERROR_NONE;
		$this->_returnData = null;
		$this->_functionValue = null;
	}
	
	protected function addError($message, $key = null)
	{
		if(!is_numeric($key) || $key === null)
		{
			$this->_errors[] = array($message);
		}else{
			$this->_errors[] = array($key => $message);
		}
	}
	
	public function addErrors($errors)
	{
		if(!(is_string($errors) || is_array($errors)))
		{
			return;
		}else if(is_array($errors))
		{
			foreach($errors as $attribute => $error)
			{
				$this->addError($error, $attribute);
			}
		}else{
			$this->addError($errors);
		}
	}
	
	public function setServiceId($serviceId)
	{
		if(is_object($serviceId))
		{
			$serviceId = get_class($serviceId);
		}
		$this->_serviceId = $serviceId;
	}
	
	public function getServiceId()
	{
		return $this->_serviceId;
	}
	
	public function setFunctionValue($functionValue)
	{
		$this->_functionValue = $functionValue;
	}
	
	public function getFunctionValue()
	{
		return $this->_functionValue;
	}
	
	public function setReturnData($data, $key = null)
	{
		if($key === null)
		{
			$this->_returnData = $data;
		}else{
			$this->_returnData[$key] = $data;
		}
	}
	
	public function getReturnData($fragment = null)
	{
		if($fragment === null)
		{
			return $this->_returnData;
		}else{
			return isset($this->_returnData[$fragment]) ? $this->_returnData[$fragment] : null;
		}
	}
	
	public function getErrors()
	{
		return $this->_errors;
	}
	
	public function getIsFailed()
	{
		return $this->_returnCode === self::FAILURE;
	}
	
	public function getIsSuccessful()
	{
		return $this->_returnCode === self::SUCCESS;
	}
	
	public function success()
	{
		$this->_returnCode = self::SUCCESS;
		$this->_errorCode = self::ERROR_NONE;
		$this->_errors = array();
		return $this;
	}
	
	public function fail($errorCode, $errors=array())
	{
		$this->_returnCode = self::FAILURE;
		$this->_errorCode = $errorCode;
		$this->addErrors($errors);
		return $this;
	}
	
	protected function normalizeData($rawData)
	{
		if(is_array($rawData))
		{
			$data = array();
			
			foreach($rawData as $key => $value)
			{
				if(is_array($value) || (is_object($value) && property_exists($value, 'attributes')))
				{
					$data[$key] = $this->normalize($value);
				}else{
					$data[$key] = $value;
				}
			}
			
			return $data;
		}else if(is_object($rawData) && property_exists($rawData, 'attributes'))
		{
			return $rawData->attributes;
		}else{
			return $rawData;
		}
	}
	
	public function getJSON($fragment=null)
	{
		if($fragment !== null)
		{
			$returnData = isset($this->_returnData[$fragment]) ? $this->_returnData[$fragment] : null;
		}else{
			$returnData = $this->_returnData;
		}
		return CJSON::encode($returnData);
	}
}
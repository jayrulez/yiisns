<?php

class WebModule extends CWebModule
{
	protected $_assetsUrl;
	
	public function init()
	{
		parent::init();
		
		$moduleId = $this->getId();
		
		$this->setImport(array(
			$moduleId.'.components.*',
			$moduleId.'.models.*',
			$moduleId.'.widgets.*',
		));
	}
	
	public function setAssetsUrl($assetsUrl)
	{
		$this->_assetsUrl = $assetsUrl;
	}
	
	public function getAssetsUrl()
	{
		return $this->_assetsUrl;
	}
	
	public function publishAssets()
	{
		$assetsPath = $this->getBasePath().DIRECTORY_SEPARATOR.'assets';
		
		if(is_dir($assetsPath))
		{
			$this->_assetsUrl = assetManager()->publish($assetsPath);
		}
	}
	
	public function getServicesPath()
	{
		return $servicesPath = $this->getBasePath().DIRECTORY_SEPARATOR.'services';
	}
	
	public function importService($serviceClass)
	{
		if(is_dir($this->getServicesPath()))
		{
			return Yii::import($this->getId().'.services.'.$serviceClass);
		}
		return null;
	}
	
	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			return true;
		}
		return false;
	}
}
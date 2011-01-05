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
			$this->_assetsUrl = Yii::app()->getAssetManager()->publish($assetsPath);
		}
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
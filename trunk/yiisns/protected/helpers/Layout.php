<?php

class LayoutBlock
{
	private $_id;
	
	private $_content;
	
	private $_weight;
	
	private $_visible;
	
	private $_htmlOptions = array();
	
	private $_tagName;
	
	private $_defaultHtmlOptions = array(
		'class'=>'block',
	);
	
	const DEFAULT_BLOCK_TAG = 'div';
	
	/**
	 *
	 */
	public function __construct($id, $content, $weight = 0, $visible = true, $htmlOptions = array(), $tagName = self::DEFAULT_BLOCK_TAG)
	{
		$this->setId($id);
		$this->setContent($content);
		$this->setWeight($weight);
		$this->setVisible($visible);
		$this->setHtmlOptions($htmlOptions);
		$this->setTagName($tagName);
	}
	
	/**
	 *
	 */	
	public function getId()
	{
		return $this->_id;
	}
	
	/**
	 *
	 */	
	public function getContent()
	{
		return $this->_content;
	}
	
	/**
	 *
	 */	
	public function getWeight()
	{
		return $this->_weight;
	}
	
	/**
	 *
	 */	
	public function getVisible()
	{
		return $this->_visible;
	}
	
	/**
	 *
	 */	
	public function getTagName()
	{
		return $this->_tagName;
	}
	
	/**
	 *
	 */	
	public function setId($id)
	{
		if(!is_string($id))
		{
			throw new CException(Yii::t('application','The block id must be a string.'));
		}
		$this->_id = $id;
		return $this;
	}
	
	/**
	 *
	 */	
	public function setContent($content)
	{
		if(!is_string($content))
		{
			throw new CException(Yii::t('application','The block content must be a string.'));
		}
		$this->_content = $content;
		return $this;
	}
	
	/**
	 *
	 */	
	public function setWeight($weight)
	{
		if(!is_numeric($weight))
		{
			throw new CException(Yii::t('application','The block weight must be a number.'));
		}
		$this->_weight = (int)$weight;
		return $this;
	}
	
	/**
	 *
	 */	
	public function setHtmlOptions($htmlOptions, $mergeOld = false)
	{
		if(!is_array($htmlOptions))
		{
			throw new CException(Yii::t('application','The block html options must be a number.'));
		}
		if($mergeOld)
		{
			$this->_htmlOptions = CMap::mergeArray($this->_htmlOptions, $htmlOptions);
		}else{
			$this->_htmlOptions = $htmlOptions;
		}
		return $this;
	}
	
	/**
	 *
	 */	
	public function setTagName($tagName)
	{
		if(!is_string($tagName))
		{
			throw new CException(Yii::t('application','The block tag name must be a string.'));
		}
		$this->_tagName = $tagName;
		return $this;
	}
	
	/**
	 *
	 */	
	public function setVisible($visible)
	{
		if(!is_bool($visible))
		{
			throw new CException(Yii::t('application','The block visibility must be set to a boolean value.'));
		}
		$this->_visible = $visible;
		return $this;
	}
	
	/**
	 *
	 */	
	public function render($return = false, $renderTag = true)
	{
		$block = $this->_content;
		if($renderTag)
		{
			$block = CHtml::openTag($this->_tagName, CMap::mergeArray($this->_defaultHtmlOptions, $this->_htmlOptions)).$block.CHtml::closeTag($this->_tagName);
		}
		if($return === true)
		{
			return $block;
		}else{
			echo $block;
		}
	}
}

class Layout
{	
	/**
	 *
	 */
	private static $_instance;
	
	/**
	 *
	 */	
	protected $regions;
	
	/**
	 *
	 */	
	public function __construct()
	{
		$this->regions = new CMap;
	}
	
	/**
	 *
	 */	
	public static function getInstance()
	{
		if(self::$_instance === null)
		{
			self::$_instance = new self;
		}
		return self::$_instance;
	}
	
	/**
	 *
	 */	
	protected static function compareBlocks($blockA, $blockB)
	{
		if($blockA instanceof LayoutBlock && $blockB instanceof LayoutBlock)
		{
			if($blockA->getWeight() === $blockB->getWeight())
			{
				return 0;
			}
			return ($blockA->getWeight() <= $blockB->getWeight()) ? -1 : 1;
		}else{
			throw new CException(Yii::t('application','Both blocks must be instances of LayoutBlock or one of it\'s children.'));
		}
	}
	
	/**
	 *
	 */	
	protected static function sortBlocks($blocks)
	{		
		$blocks = $blocks->toArray();
		
		uasort($blocks, array(__CLASS__,'compareBlocks'));
		
		return new CMap($blocks);
	}
	
	/**
	 *
	 */	
	public function getBlocks($regionId, $visibleOnly = true)
	{
		$instance = self::getInstance();
		
		$blocks   = new CMap;
		
		if($instance->regions->contains($regionId))
		{			
			foreach($instance->regions[$regionId] as $blockId => $block)
			{
				if($visibleOnly)
				{
					if($block->getVisible() === false)
					{
						continue;
					}
				}
				$blocks->add($blockId, $block);
			}
		}
		
		return self::sortBlocks($blocks);
	}
	
	/**
	 *
	 */	
	public static function addBlock($regionId, $blockData)
	{
		if(isset($blockData['id']))
		{
			$instance    = self::getInstance();
			
			$blockId     = $blockData['id'];
			$content     = $blockData['content'];
			
			$weight      = isset($blockData['weight'])      ? $blockData['weight']      : 0;
			$visible     = isset($blockData['visible'])     ? $blockData['visible']     : true;
			$htmlOptions = isset($blockData['htmlOptions']) ? $blockData['htmlOptions'] : array();
			$tagName     = isset($blockData['tagName'])     ? $blockData['tagName']     : LayoutBlock::DEFAULT_BLOCK_TAG;
			
			$block       = new LayoutBlock($blockId, $content, $weight, $visible, $htmlOptions);
			
			if(!$instance->regions->contains($regionId))
			{
				$instance->regions[$regionId] = new CMap;
			}
			$instance->regions[$regionId]->add($blockId, $block);
		}else{
			throw new CException(Yii::t('application','A block must have at least an id.'));
		}
	}
	
	/**
	 *
	 */	
	public static function addBlocks($blocks = array())
	{
		foreach($blocks as $blockData)
		{
			if(isset($blockData['regionId']))
			{
				$regionId = $blockData['regionId'];
				unset($blockData['regionId']);
				self::addBlock($regionId, $blockData);
			}
		}
	}
	
	/**
	 *
	 */	
	public static function getBlock($regionId, $blockId)
	{
		$instance = self::getInstance();
		if(($region = self::getRegion($regionId)) !== null)
		{
			if($region->contains($blockId))
			{
				return $region[$blockId];
			}
		}
		return null;
	}
	
	/**
	 *
	 */	
	public static function hasBlock($regionId, $blockId)
	{
		return self::getBlock($regionId, $blockId) !== null;
	}
	
	/**
	 *
	 */	
	public static function removeBlock($regionId, $blockId)
	{
		if(($region = self::getRegion($regionId)) !== null)
		{
			if($region->contains($blockId))
			{
				$region->remove($blockId);
			}
		}
	}
	
	/**
	 *
	 */	
	public static function getRegion($regionId)
	{
		$instance = self::getInstance();
		return $instance->regions->contains($regionId) ? $instance->regions[$regionId] : null;
	}
	
	/**
	 *
	 */	
	public static function hasRegion($regionId)
	{
		return self::getRegion($regionId) !== null;
	}
	
	/**
	 *
	 */	
	public static function hasRegions()
	{
		$args = func_get_args();
		if(count($args))
		{
			foreach($args as $regionId)
			{
				if(!self::hasRegion($regionId))
				{
					return false;
				}
			}
			return true;
		}
		throw new CException(Yii::t('application','No region id was specified.'));
	}
	
	/**
	 *
	 */	
	public static function renderRegion($regionId, $return = false)
	{
		$regionContent = '';
		
		if(self::hasRegion($regionId))
		{
			$blocks = self::getBlocks($regionId);
			
			foreach($blocks as $block)
			{
				if($block instanceof LayoutBlock)
				{
					$regionContent .= $block->render(true);
				}
			}
		}
		
		if($return)
		{
			return $regionContent;
		}else{
			echo $regionContent;
		}
	}
	
	/**
	 *
	 */	
	public static function removeRegion($regionId)
	{
		$instance = self::getInstance();
		
		if($instance->regions->contains($regionId))
		{
			$instance->regions->remove($regionId);
		}
	}
}
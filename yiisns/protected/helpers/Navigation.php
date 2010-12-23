<?php

class Menu extends CComponent
{
	protected $_id;
	protected $_items;
	protected $_htmlOptions = array();
	
	public function __construct($id, $htmlOptions = array())
	{
		$this->setId($id);
		$this->setHtmlOptions($htmlOptions);
		$this->_items = new CMap;
		$this->init();
	}
	
	public function init()
	{
	}
	
	public function getId()
	{
		return $this->_id;
	}
	
	public function getHtmlOptions()
	{
		return $this->_htmlOptions;
	}
	
	public function setId($id)
	{
		if(!is_string($id))
		{
			throw new CException(Yii::t('application','The id must be a string.'));
		}
		$this->_id = $id;
		return $this;
	}
	
	public function setHtmlOptions($htmlOptions, $mergeOld = false)
	{
		if(!is_array($htmlOptions))
		{
			throw new CException(Yii::t('application','The html options must be a number.'));
		}
		if($mergeOld)
		{
			$this->_htmlOptions = CMap::mergeArray($this->_htmlOptions, $htmlOptions);
		}else{
			$this->_htmlOptions = $htmlOptions;
		}
		return $this;
	}
	
	public function addItem($itemData)
	{
		if(isset($itemData['id'], $itemData['label']))
		{
			$id          = $itemData['id'];
			$label       = $itemData['label'];
			$url         = isset($itemData['url'])         ? $itemData['url'] : '#';
			$weight      = isset($itemData['weight'])      ? $itemData['weight'] : 0;
			$icon        = isset($itemData['icon'])        ? $itemData['icon'] : array();
			$htmlOptions = isset($itemData['htmlOptions']) ? $itemData['htmlOptions'] : array();
			$linkOptions = isset($itemData['linkOptions']) ? $itemData['linkOptions'] : array();
			$visible     = isset($itemData['visible'])     ? $itemData['visible'] : true;
			
			$this->_items->add($id, new MenuItem($id, $label, $url, $weight, $icon, $htmlOptions, $linkOptions, $visible));
			
			if(isset($itemData['items']) && is_array($itemData['items']))
			{
				$this->_items[$id]->addItems($itemData['items']);
			}
		}else{
			throw new CException(Yii::t('application','The item id and label must at least be specified.'));
		}
	}
	
	public function addItems($items)
	{
		foreach($items as $itemData)
		{
			$this->addItem($itemData);
		}
	}
	
	public function removeItem($itemId)
	{
		if($this->_items->contains($itemId))
		{
			$this->_items->remove($itemId);
		}
	}
	
	public function getItems()
	{
		return $this->_items;
	}
	
	public function getItem($itemId)
	{
		return $this->_items->contains($itemId) ? $this->_items[$itemId] : null;
	}
	
	public function hasItem($itemId)
	{
		return $this->getItem($itemId) !== null;
	}
	
	public function getIsEmpty()
	{
		$count = 0;
		foreach($this->_items as $item)
		{
			if($item->getVisible())
			{
				$count++;
			}
		}
		return $count === 0;
	}
	
	public function getVisibleItems()
	{
		$visibleItems = new CMap;
		
		foreach($this->getItems() as $id => $item)
		{
			if($item->getVisible()===true)
			{
				$visibleItems->add($id, $item);
			}
		}
		return $visibleItems;
	}
	
	protected function compareItems($itemA, $itemB)
	{
		if($itemA instanceof MenuItem && $itemB instanceof MenuItem)
		{
			if($itemA->getWeight() === $itemB->getWeight())
			{
				return 0;
			}
			return ($itemA->getWeight() <= $itemB->getWeight()) ? -1 : 1;
		}else{
			throw new CException(Yii::t('application','Both items must be instances of MenuItem or one of it\'s children.'));
		}
	}
	
	protected function sortItems($items)
	{
		$items = $items->toArray();
		
		uasort($items,array($this,'compareItems'));
		
		return new CMap($items);
	}
	
	public function render($return = false)
	{
		$menuContent = '';
		
		if($this->getVisibleItems()->count())
		{
			$menuContent .= CHtml::openTag('ul', $this->_htmlOptions)."\n";
			$menuContent .= $this->renderRecursive($this->getVisibleItems(), true);
			$menuContent .= CHtml::closeTag('ul')."\n";
		}
		if($return)
		{
			return $menuContent;
		}else{
			echo $menuContent;
		}
	}
	
	protected function renderRecursive($items, $return = false)
	{
		$items = $this->sortItems($items);
		
		$content = '';
		
		foreach($items as $item)
		{
			if($item instanceof MenuItem)
			{
				if($item->getVisible())
				{
					$iconImgTag = '';
					$icon = $item->getIcon();
					if(isset($icon['src']))
					{
						$iconImgTag = CHtml::image($icon['src'], isset($icon['alt']) ? $icon['alt'] : '', isset($icon['htmlOptions']) ? $icon['htmlOptions'] : array());
					}
					
					$linkOptions = $item->getLinkOptions();
					
					$linkOptions['href'] = $item->getUrl();
					
					$linkTemplate = isset($linkOptions['template']) ? $linkOptions['template'] : '{openTag}{icon}{label}{closeTag}';
					
					unset($linkOptions['template']);
					
					if(!isset($linkOptions['id']))
					{
						$linkOptions['id'] = $item->getId();
					}
					
					$content .= CHtml::openTag('li',$item->getHtmlOptions())."\n";
					
					$content .= strtr($linkTemplate, array(
						'{openTag}'  => CHtml::openTag('a', $linkOptions),
						'{icon}'     => $iconImgTag,
						'{label}'    => $item->getLabel(),
						'{closeTag}' => CHtml::closeTag('a'),
					));
					
					if(count($item->getVisibleItems()))
					{
						$content .= CHtml::openTag('ul')."\n";
						$content .= self::renderRecursive($item->getVisibleItems(), true);
						$content .= CHtml::closeTag('ul')."\n";
					}
					
					$content .= CHtml::closeTag('li')."\n";
				}
			}
		}
		
		if($return)
		{
			return $content;
		}else{
			echo $content;
		}
	}
}

class MenuItem extends Menu
{
	protected $_label;
	protected $_url;
	protected $_weight;
	protected $_icon = array();
	protected $_linkOptions = array();
	protected $_visible;
	
	public function __construct($id, $label, $url = '#', $weight = 0, $icon = array(), $htmlOptions = array(), $linkOptions = array(), $visible = true)
	{
		$this->setId($id);
		$this->setLabel($label);
		$this->setUrl($url);
		$this->setWeight($weight);
		$this->setIcon($icon);
		$this->setHtmlOptions($htmlOptions);
		$this->setLinkOptions($linkOptions);
		$this->setVisible($visible);
		
		$this->_items = new CMap;
		
		$this->init();
	}
	
	public function init()
	{
		parent::init();
	}
	
	public function getLabel()
	{
		return $this->_label;
	}
	
	public function getUrl()
	{
		return $this->_url;
	}
	
	public function getWeight()
	{
		return $this->_weight;
	}
	
	public function getIcon()
	{
		return $this->_icon;
	}
	
	public function getLinkOptions()
	{
		return $this->_linkOptions;
	}
	
	public function getVisible()
	{
		return $this->_visible;
	}
	
	public function setLabel($label)
	{
		if(!is_string($label))
		{
			throw new CException(Yii::t('application','The item label must be a string.'));
		}
		$this->_label = $label;
		return $this;
	}
	
	public function setUrl($url)
	{
		if(!(is_array($url) || is_string($url)))
		{
			throw new CException(Yii::t('application','The item url must be a string or an array.'));
		}
		$this->_url = $url;
		return $this;
	}
	
	public function setWeight($weight)
	{
		if(!is_numeric($weight))
		{
			throw new CException(Yii::t('application','The item weight must be a number.'));
		}
		$this->_weight = (int)$weight;
		return $this;
	}
	
	public function setIcon($icon)
	{
		if(is_string($icon))
		{
			$this->_icon = array('src'=>$icon);
		}else if(is_array($icon) && (isset($icon['src']) || empty($icon)))
		{
			$this->_icon = $icon;
		}else{
			throw new CException(Yii::t('application','The item icon must be a string or an array containing "src" and/or "alt" or empty.'));
		}
		return $this;
	}
	
	public function setLinkOptions($linkOptions, $mergeOld = false)
	{
		if(!is_array($linkOptions))
		{
			throw new CException(Yii::t('application','The item link options must be a number.'));
		}
		if($mergeOld)
		{
			$this->_linkOptions = CMap::mergeArray($this->_linkOptions, $linkOptions);
		}else{
			$this->_linkOptions = $linkOptions;
		}
		return $this;
	}
	
	public function setVisible($visible)
	{
		if(!is_bool($visible))
		{
			throw new CException(Yii::t('application','The item visibility must be set to a boolean value.'));
		}
		$this->_visible = $visible;
		return $this;
	}
}

class Navigation
{
	private static $_instance;
	
	private $_menus = array();
	
	public function __construct()
	{
		$this->_menus = new CMap;
	}
	
	public static function getInstance()
	{
		if(self::$_instance === null)
		{
			self::$_instance = new self;
		}
		return self::$_instance;
	}
	
	public static function getMenu($menuId)
	{
		$instance = self::getInstance();
		
		if(!$instance->_menus->contains($menuId))
		{
			$instance->_menus[$menuId] = new Menu($menuId);
		}
		return $instance->_menus[$menuId];
	}
	
	public static function removeMenu($menuId)
	{
		$instance = self::getInstance();
		if($instance->_menus->contains($menuId))
		{
			$instance->_menus->remove($menuId);
		}
	}
	
	public static function render($menuId, $return = false)
	{
		$menuData = '';
		if(($menu = self::getMenu($menuId)) !== null)
		{
			if(count($menu))
			{
				$menuData = $menu->render(true);
			}
		}
		if($return)
		{
			return $menuData;
		}else{
			echo $menuData;
		}
	}
}
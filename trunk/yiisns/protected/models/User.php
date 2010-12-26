<?php

class User extends CActiveRecord
{
	const PHOTO_SIZE_MINI    = 1;
	const PHOTO_SIZE_SMALL   = 2;
	const PHOTO_SIZE_MEDIUM  = 3;
	const PHOTO_SIZE_LARGE   = 4;
	const PHOTO_SIZE_DEFAULT = 5;
	
	public function getPhotoSizes()
	{
		return array(
			User::PHOTO_SIZE_MINI => array('width'=>30, 'height'=>30),
			User::PHOTO_SIZE_SMALL => array('width'=>48, 'height'=>48),
			User::PHOTO_SIZE_MEDIUM => array('width'=>48, 'height'=>48),
			User::PHOTO_SIZE_LARGE => array('width'=>48, 'height'=>48),
			User::PHOTO_SIZE_DEFAULT => array('width'=>48, 'height'=>48),
		);
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('username, password', 'required'),
			array('username, password', 'length', 'max'=>32),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'aspects' => array(self::HAS_MANY, 'Aspect', 'user_id'),
			'comments' => array(self::HAS_MANY, 'Comment', 'user_id'),
			'contacts' => array(self::HAS_MANY, 'Contact', 'user_id'),
			'notifications' => array(self::HAS_MANY, 'Notification', 'user_id'),
			'posts' => array(self::HAS_MANY, 'Post', 'user_id'),
			'profile' => array(self::HAS_ONE, 'Profile', 'user_id'),
			'requests' => array(self::HAS_MANY, 'Request', 'contact_id'),
			'sentRequests' => array(self::HAS_MANY, 'Request', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username',
			'password' => 'Password',
			'create_ip' => 'Create Ip',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
		);
	}

	public static function encryptPassword($password, $length = 32)
	{
		$password = md5($password);
		
		if(strlen($password) > $length)
		{
			$password = substr($password, 0, 32);
		}
		return $password;
	}
	
	public function beforeSave()
	{
		if(parent::beforeSave())
		{
			$this->username = strtolower($this->username);
			if($this->getIsNewRecord())
			{
				$this->password = self::encryptPassword($this->password);
				$this->create_ip = Yii::app()->request->getUserHostAddress();
				$this->create_time = time();
			}else{
				/*if($this->scenario === 'updatePassword')
				{
					$this->password = self::encryptPassword($this->password);
				}*/
				$this->update_time = time();
			}
			return true;
		}
		return false;
	}
	
	
	public function getImageSrc($size=User::PHOTO_SIZE_SMALL)
	{
		$photo = '';
		switch($size)
		{
			case User::PHOTO_SIZE_MINI:
				$photo = 'user_icon_mini.png';
			break;
			
			case User::PHOTO_SIZE_SMALL:
				$photo = 'user_icon_small.png';
			break;
			
			case User::PHOTO_SIZE_MEDIUM:
				$photo = 'user_icon_medium.png';
			break;
			
			case User::PHOTO_SIZE_LARGE:
				$photo = 'user_icon_large.png';
			break;
			
			case User::PHOTO_SIZE_DEFAULT:
			default:
				$photo = 'user_icon_default.png';
			break;
		}
		return Yii::app()->baseUrl.'/images/'.$photo;
	}
	
	public function getImage($size=User::PHOTO_SIZE_SMALL, $htmlOptions = array())
	{
		return CHtml::image($this->getImageSrc($size), $this->getDisplayName(), $htmlOptions);
	}
	
	public function getImageLink($size=User::PHOTO_SIZE_SMALL, $linkHtmlOptions=array(), $imageHtmlOptions = array())
	{
		$linkHtmlOptions['title'] = $this->getDisplayName();
		return CHtml::link($this->getImage($size, $imageHtmlOptions), $this->getUrl(), $linkHtmlOptions);
	}
	
	public function getUrl()
	{
		return Yii::app()->createUrl('/profile/view', array('id'=>$this->id));
	}
	
	public function getDisplayName()
	{
		return $this->profile !== null ? $this->profile->getFullName() : $this->username;
	}
	
	public function getLink($htmlOptions = array())
	{
		return CHtml::link($this->getDisplayName(), $this->getUrl(), $htmlOptions);
	}
	
	public function getRequest($userId)
	{
		$request = Request::model()->findByAttributes(array(
			'user_id'=>$this->id,
			'contact_id'=>$userId,
		));
		
		return $request;
	}
	
	public function getRelationshipLink($viewerId)
	{
		$viewer = User::model()->findByPk($viewerId);
		
		if($viewer === null)
		{
			return null;
		}
		
		if(Util::areContacts($this->id, $viewer->id))
		{
			return CHtml::link(Yii::t('application', 'Remove contact'), array('/contact/delete', 'id'=>$this->id));
		}else if(($request=$this->getRequest($viewer->id))!==null)
		{
			return CHtml::link(Yii::t('application', 'Respond to contact request'), array('/contact/requests'));
		}else if($viewer->getRequest($this->id) !== null)
		{
			return CHtml::link(Yii::t('application', 'Contact request pending'), array('/contact/sentRequests'));
		}else{
			return CHtml::link(Yii::t('application', 'Add contact'), array('/contact/sendRequest', 'id'=>$this->id));
		}
	}
}
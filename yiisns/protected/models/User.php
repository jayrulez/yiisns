<?php

class User extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'user';
	}

	public function rules()
	{
		return array(
			array('username, password', 'required'),
			array('username, password', 'length', 'min'=>3, 'max'=>32),
		);
	}

	public function relations()
	{
		return array(
			'aspects' => array(self::HAS_MANY, 'Aspect', 'user_id'),
			'comments' => array(self::HAS_MANY, 'Comment', 'user_id'),
			'contacts' => array(self::HAS_MANY, 'Contact', 'user_id'),
			'notifications' => array(self::HAS_MANY, 'Notification', 'user_id'),
			'photos' => array(self::HAS_MANY, 'Photo', 'user_id'),
			'photoAlbums' => array(self::HAS_MANY, 'PhotoAlbum', 'user_id'),
			'posts' => array(self::HAS_MANY, 'Post', 'user_id'),
			'profile' => array(self::HAS_ONE, 'Profile', 'user_id'),
			'requestsReceived' => array(self::HAS_MANY, 'Request', 'contact_id'),
			'requestsSent' => array(self::HAS_MANY, 'Request', 'user_id'),
		);
	}

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
	
	public static function encryptPassword($password)
	{
		return md5($password);
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
				$this->update_time = time();
			}
			return true;
		}
		return false;
	}
	
	public function afterSave()
	{
		if($this->getIsNewRecord())
		{
			$profile = new Profile;
			$profile->user_id = $this->id;
			$profile->save(false);
			$this->addProfilePhotoAlbum();
		}
	}
	
	public function addPhotoAlbum($type=PhotoAlbum::TYPE_USER, $name, $caption=null, $validate = false)
	{
		$photoAlbum = new PhotoAlbum;
		$photoAlbum->user_id = $this->id;
		$photoAlbum->type = $type;
		$photoAlbum->name = $name;
		$photoAlbum->caption = $caption;
		return $photoAlbum->save($validate);
	}
	
	public function addProfilePhotoAlbum($validate = false)
	{
		return $this->addPhotoAlbum(PhotoAlbum::TYPE_PROFILE, Yii::t('application','Profile Pictures'));
	}
	
	public function getProfilePhotoAlbum()
	{
		$profilePhotoAlbum = PhotoAlbum::model()->findByAttributes(array(
			'user_id'=>$this->id,
			'type'=>PhotoAlbum::TYPE_PROFILE,
		));
		
		return $profilePhotoAlbum;
	}
	
	public function beforeFind()
	{
		if(parent::beforeFind())
		{
			$this->username = strtolower($this->username);
			
			return true;
		}
		return false;
	}
	
	public function getDisplayName()
	{
		return $this->profile !== null ? $this->profile->getFullName() : $this->username;
	}
	
	public function getUrl()
	{
		return Yii::app()->createUrl('/profile/view', array(
			'id'=>$this->id,
		));
	}
	
	public function getLink($displayName = null, $htmlOptions = array())
	{
		return CHtml::link(($displayName !== null) ? $displayName : $this->getDisplayName(), $this->getUrl(), $htmlOptions);
	}
	
	public function getAspectIds()
	{
		$aspectIds = array();
		
		foreach($this->aspects as $aspect)
		{
			$aspectIds[] = $aspect->id;
		}
		
		return $aspectIds;
	}
	
	public function getDefaultImgSrc($imageSize)
	{
		switch($imageSize)
		{
			case Photo::SIZE_MICRO:
				$photoName = 'user_icon_micro';
			break;
			case Photo::SIZE_MINI:
				$photoName = 'user_icon_mini';
			break;
			case Photo::SIZE_SMALL:
				$photoName = 'user_icon_small';
			break;
			case Photo::SIZE_MEDIUM:
				$photoName = 'user_icon_medium';
			break;
			case Photo::SIZE_LARGE:
			case Photo::SIZE_ORIGINAL:
			default:
				$photoName = 'user_icon_large';
			break;
		}
		return Yii::app()->getBaseUrl().'/images/'.$photoName.'.png';
	}
	
	public function getImageSrc($imageSize=Photo::SIZE_MEDIUM)
	{
		if(($profile = $this->profile) !== null)
		{
			if(($photo = Photo::model()->findByPk($profile->photo_id))!== null)
			{
				return ($src = $photo->getSrcAsSize($imageSize)) !== null ? $src : self::getDefaultImgSrc($imageSize);
			}
		}
		return self::getDefaultImgSrc($imageSize);
	}
	
	public function getImage($imageSize=Photo::SIZE_MEDIUM, $htmlOptions = array())
	{
		return CHtml::image($this->getImageSrc($imageSize), $this->getDisplayName(), $htmlOptions);
	}
	
	public function getImageLink($imageSize=Photo::SIZE_MEDIUM, $linkHtmlOptions=array(), $imageHtmlOptions=array())
	{
		return $this->getLink($this->getImage($imageSize, $imageHtmlOptions), $linkHtmlOptions);
	}
	
	public function canCommentOnPost($postId)
	{
		return true;
	}
	
	public function canSeePost($postId)
	{
		$post = Post::model()->findBySql("select * 
			from post 
			WHERE post.id=:post_id AND (post.user_id=:viewer_id 
			OR post.id IN (SELECT pa.post_id 
				FROM post_aspect as pa INNER JOIN contact_aspect as ca on ca.aspect_id=pa.aspect_id 
				WHERE ca.contact_id=:viewer_id 
				AND ca.user_id IN (SELECT contact_id 
					FROM contact 
					WHERE contact.user_id=:viewer_id
				)
			)
		)", array(
			':post_id'=>$postId,
			':viewer_id'=>$this->id,
		));
		
		return $post !== null;
	}
	
	public function findRequest($contactId)
	{
		$request = Request::model()->findByAttributes(array(
			'user_id'=>$this->id,
			'contact_id'=>$contactId,
		));
		
		return $request;
	}
	
	public static function areContacts($userId, $contactId)
	{
		$contact = Contact::model()->findBySql("SELECT l.* 
			FROM contact AS l INNER JOIN contact as r ON (l.user_id=r.contact_id AND l.contact_id=r.user_id) 
			WHERE l.user_id=:user_id AND l.contact_id=:contact_id
		", array(
			':user_id'=>$userId,
			':contact_id'=>$contactId,
		));
		return $contact !== null;
	}
	
	public function getRelationshipLink($viewerId)
	{
		$viewer = User::model()->findByPk($viewerId);
		
		if($viewer === null || $this->id === $viewer->id)
		{
			return null;
		}else{
			if(self::areContacts($this->id, $viewerId))
			{
				return CHtml::link(Yii::t('application', 'Remove contact'), array(
					'/contact/delete',
					'id'=>$this->id,
				));
			}else{
				if($this->findRequest($viewer->id)!==null)
				{
					return CHtml::link(Yii::t('application', 'Respond to contact request'), array(
						'/contact/requests',
						'type'=>Request::TYPE_RECEIVED,
					));
				}else if($viewer->findRequest($this->id) !== null)
				{
					return CHtml::link(Yii::t('application', 'Contact request pending'), array(
						'/contact/requests',
						'type'=>Request::TYPE_SENT,
					));
				}else{
					return CHtml::link(Yii::t('application', 'Add as contact'), array(
						'/contact/add',
						'id'=>$this->id,
					));
				}
			}
		}
	}
	
	public function getPath()
	{
		$path = UPLOAD_PATH.'/user/'.$this->id;
		if(!is_dir($path))
		{
			@mkdir($path, 777, true);
		}
		return $path;
	}
}
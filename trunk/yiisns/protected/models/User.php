<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $create_ip
 * @property string $create_time
 * @property string $update_time
 *
 * The followings are the available model relations:
 * @property Aspect[] $aspects
 * @property Comment[] $comments
 * @property Contact[] $contacts
 * @property Notification[] $notifications
 * @property Post[] $posts
 * @property Profile $profile
 * @property Request[] $requestsReceived
 * @property Request[] $requestsSent
 */
class User extends CActiveRecord
{
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
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password', 'required'),
			array('username, password', 'length', 'min'=>3, 'max'=>32),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, password, create_ip, create_time, update_time', 'safe', 'on'=>'search'),
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
			'requestsReceived' => array(self::HAS_MANY, 'Request', 'contact_id'),
			'requestsSent' => array(self::HAS_MANY, 'Request', 'user_id'),
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

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('create_ip',$this->create_ip,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
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
		return $this->username;
	}
	
	public function getUrl()
	{
		return Yii::app()->createUrl('/user/view', array(
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
	
	public function getImageSrc($imageSize=1)
	{
		return Yii::app()->getBaseUrl().'/images/user_icon_mini.png';
	}
	
	public function getImage($imageSize=1, $htmlOptions = array())
	{
		return CHtml::image($this->getImageSrc($imageSize), $this->getDisplayName(), $htmlOptions);
	}
	
	public function getImageLink($imageSize=1, $linkHtmlOptions=array(), $imageHtmlOptions=array())
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
}
<?php

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
			'posts' => array(self::HAS_MANY, 'Post', 'user_id'),
			'requests' => array(self::HAS_MANY, 'Request', 'contact_id'),
			'invitations' => array(self::HAS_MANY, 'Request', 'user_id'),
			'profile' => array(self::HAS_ONE, 'Profile', 'user_id'),
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
	
	public function canSeeAspect($aspectId)
	{
		$aspect = Aspect::model()->findByPk($aspectId);
		
		if($aspect !== null)
		{
			if($aspect->user->id === $this->id)
			{
				return true;
			}else{
				$contactAspect = ContactAspect::model()->findByAttributes(array(
					'contact_id'=>$this->id,
					'aspect_id'=>$aspectId,
				));
				
				if($contactAspect !== null)
				{
					return true;
				}
			}
		}
		return false;
	}
	
	public function getLink($htmlOptions = array())
	{
		return CHtml::link($this->profile !== null ? $this->profile->getFullName() : $this->username, array('/profile/view','id'=>$this->id), $htmlOptions);
	}
}
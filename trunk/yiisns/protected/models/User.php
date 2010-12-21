<?php

/**
 * This is the model class for table "yiisns.user".
 *
 * The followings are the available columns in table 'yiisns.user':
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
 * @property Post[] $posts
 * @property Request[] $requests
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
		return 'yiisns.user';
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
			array('username, password', 'length', 'max'=>32),
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
			'posts' => array(self::HAS_MANY, 'Post', 'user_id'),
			'requestsI' => array(self::HAS_MANY, 'Request', 'contact_id'),
			'requestsO' => array(self::HAS_MANY, 'Request', 'user_id'),
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
				if($this->scenario === 'updatePassword')
				{
					$this->password = self::encryptPassword($this->password);
				}
				$this->update_time = time();
			}
			return true;
		}
		return false;
	}
}
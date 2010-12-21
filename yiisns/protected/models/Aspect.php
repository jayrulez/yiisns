<?php

/**
 * This is the model class for table "yiisns.aspect".
 *
 * The followings are the available columns in table 'yiisns.aspect':
 * @property string $id
 * @property string $user_id
 * @property string $name
 * @property string $create_time
 * @property string $update_time
 *
 * The followings are the available model relations:
 * @property User $user
 * @property ContactAspect[] $contactAspects
 * @property Post[] $posts
 */
class Aspect extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Aspect the static model class
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
		return 'yiisns.aspect';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, name, create_time, update_time', 'required'),
			array('user_id, create_time, update_time', 'length', 'max'=>11),
			array('name', 'length', 'max'=>32),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, name, create_time, update_time', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'posts' => array(self::MANY_MANY, 'Post', 'post_aspect(aspect_id, post_id)'),
		);
	}

	public function getContacts()
	{
		$userContacts = Contact::model()->findAllByAttributes(array(
			'user_id'=>$this->user_id,
		));
		
		$contacts = array();
		
		foreach($userContacts as $userContact)
		{
			
		}
		
		return $contacts;
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'name' => 'Name',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
		);
	}
}
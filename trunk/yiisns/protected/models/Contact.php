<?php

/**
 * This is the model class for table "yiisns.contact".
 *
 * The followings are the available columns in table 'yiisns.contact':
 * @property string $user_id
 * @property string $contact_id
 *
 * The followings are the available model relations:
 * @property User $contact
 * @property User $user
 * @property ContactAspect[] $contactAspects
 */
class Contact extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Contact the static model class
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
		return 'yiisns.contact';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, contact_id', 'required'),
			array('user_id, contact_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, contact_id', 'safe', 'on'=>'search'),
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
			'contact' => array(self::BELONGS_TO, 'User', 'contact_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'contactAspects' => array(self::HAS_MANY, 'ContactAspect', 'contact_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'contact_id' => 'Contact',
		);
	}
}
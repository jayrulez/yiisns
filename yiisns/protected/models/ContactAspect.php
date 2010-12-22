<?php

class ContactAspect extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ContactAspect the static model class
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
		return 'contact_aspect';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('user_id, contact_id, aspect_id', 'required'),
			array('user_id, contact_id, aspect_id', 'length', 'max'=>11),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'aspect' => array(self::BELONGS_TO, 'Aspect', 'aspect_id'),
			'user' => array(self::BELONGS_TO, 'Contact', 'user_id'),
			'contact' => array(self::BELONGS_TO, 'Contact', 'contact_id'),
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
			'aspect_id' => 'Aspect',
		);
	}
}
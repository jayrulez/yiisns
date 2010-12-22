<?php

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
		return 'contact';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('user_id, person_id', 'required'),
			array('user_id, person_id', 'length', 'max'=>11)
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'person' => array(self::BELONGS_TO, 'User', 'person_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'aspects' => array(self::MANY_MANY, 'Aspect', 'contact_aspect(user_id, person_id, aspect_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'person_id' => 'Contact',
		);
	}
}
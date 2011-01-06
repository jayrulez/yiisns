<?php

class Request extends CActiveRecord
{
	const TYPE_RECEIVED = 1;
	const TYPE_SENT = 2;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'request';
	}

	public function rules()
	{
		return array(
		);
	}

	public function relations()
	{
		return array(
			'contact' => array(self::BELONGS_TO, 'User', 'contact_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'contact_id' => 'Contact',
		);
	}
	
	public static function getTypes()
	{
		return array(
			self::TYPE_RECEIVED,
			self::TYPE_SENT,
		);
	}
}
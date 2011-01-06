<?php

class Notification extends CActiveRecord
{
	const STATUS_NEW = 1;
	const STATUS_READ = 2;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'notification';
	}

	public function rules()
	{
		return array(
		);
	}

	public function relations()
	{
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'type' => 'Type',
			'content' => 'Content',
			'status' => 'Status',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
		);
	}
	
	public function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->getIsNewRecord())
			{
				$this->create_time = time();
			}else{
				$this->update_time = time();
			}
			return true;
		}
		
		return false;
	}
}
<?php

class Comment extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'comment';
	}

	public function rules()
	{
		return array(
			array('content', 'required'),
			array('post_id', 'exist', 'className'=>'Post', 'attributeName'=>'id'),
		);
	}

	public function relations()
	{
		return array(
			'post' => array(self::BELONGS_TO, 'Post', 'post_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'post_id' => 'Post',
			'content' => 'Content',
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
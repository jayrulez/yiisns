<?php

class Aspect extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'aspect';
	}

	public function rules()
	{
		return array(
			array('name', 'required'),
			array('name', 'length', 'min'=>3, 'max'=>32),
			array('name', 'uniqueOnUserId'),
		);
	}

	public function uniqueOnUserId($attribute, $params = array())
	{
		$aspect = Aspect::model()->findByAttributes(array(
			'user_id'=>$this->user_id,
			'name'=>$this->name,
		));
		
		if($aspect !== null && $aspect->id !== $this->id)
		{
			$this->addError('name', Yii::t('application', 'You already have an aspect named "{name}".', array(
				'{name}'=>$this->name,
			)));
		}
	}

	public function relations()
	{
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'contacts' => array(self::MANY_MANY, 'Contact', 'contact_aspect(user_id, contact_id, aspect_id)'),
			'posts' => array(self::MANY_MANY, 'Post', 'post_aspect(aspect_id, post_id)'),
		);
	}

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
	
	public function getUrl()
	{
		return Yii::app()->createUrl('/aspect/view', array(
			'id'=>$this->id,
		));
	}
	
	public function getLink($htmlOptions = array())
	{
		return CHtml::link($this->name, $this->getUrl(), $htmlOptions);
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
	
	public function getContactCount()
	{
		$contacts = $this->dbConnection->createCommand("SELECT * FROM contact_aspect WHERE user_id=:user_id AND aspect_id=:aspect_id")->bindValues(array(
			':user_id'=>$this->user->id,
			':aspect_id'=>$this->id,
		))->queryAll();
		
		return count($contacts);
	}
}
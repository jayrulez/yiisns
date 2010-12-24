<?php

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
		return 'aspect';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
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
		
		if($aspect !== null)
		{
			$this->addError('name', Yii::t('application', 'You already have an aspect named "{name}".', array(
				'{name}'=>$this->name,
			)));
		}
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'contacts' => array(self::MANY_MANY, 'Contact', 'contact_aspect(user_id, contact_id, aspect_id)'),
			'posts' => array(self::MANY_MANY, 'Post', 'post_aspect(aspect_id, post_id)'),
		);
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
	
	public function getLink($htmlOptions = array())
	{
		return CHtml::link($this->name, array('/aspect/view', 'id'=>$this->id), $htmlOptions);
	}
}
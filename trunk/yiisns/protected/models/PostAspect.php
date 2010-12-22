<?php

class PostAspect extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return PostAspect the static model class
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
		return 'post_aspect';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('post_id, aspect_id', 'required'),
			array('post_id, aspect_id', 'length', 'max'=>11),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'aspect' => array(self::BELONGS_TO, 'Aspect', 'aspect_id'),
			'post' => array(self::BELONGS_TO, 'Post', 'post_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'post_id' => 'Post',
			'aspect_id' => 'Aspect',
		);
	}
}
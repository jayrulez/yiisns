<?php

class Profile extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Profile the static model class
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
		return 'profile';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('first_name, last_name, gender, birthday', 'required'),
			array('gender', 'numerical', 'integerOnly'=>true),
			array('first_name, last_name', 'length', 'max'=>32),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'gender' => 'Gender',
			'birthday' => 'Birthday',
		);
	}
	
	public function getFullName()
	{
		$fullName = $this->first_name;
		if(!empty($this->last_name))
		{
			$fullName .= ' '.$this->last_name;
		}
		
		return $fullName;
	}
}
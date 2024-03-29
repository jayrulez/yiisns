<?php

class Profile extends CActiveRecord
{
	const GENDER_MALE = 1;
	const GENDER_FEMALE = 2;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'profile';
	}

	public function rules()
	{
		return array(
			array('first_name, birthday', 'required'),
			array('gender', 'checkGender'),
			array('first_name, last_name', 'length', 'max'=>32),
		);
	}
	
	public function checkGender()
	{
		if(!array_key_exists($this->gender, self::getGenders()))
		{
			$this->addError('gender',Yii::t('application','You must select a gender.'));
		}
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
	
	public static function getGenders()
	{
		return array(
			self::GENDER_MALE=>Yii::t('application','Male'),
			self::GENDER_FEMALE=>Yii::t('application','Female'),
		);
	}
	
	public function getGenderText()
	{
		$genders = self::getGenders();
		return isset($genders[$this->gender]) ? $genders[$this->gender] : '';
	}
}
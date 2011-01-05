<?php

/**
 * This is the model class for table "profile".
 *
 * The followings are the available columns in table 'profile':
 * @property string $user_id
 * @property string $first_name
 * @property string $last_name
 * @property integer $gender
 * @property string $birthday
 *
 * The followings are the available model relations:
 * @property User $user
 */
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
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, first_name, last_name, gender, birthday', 'required'),
			array('gender', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>11),
			array('first_name, last_name', 'length', 'max'=>32),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, first_name, last_name, gender, birthday', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
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

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('gender',$this->gender);
		$criteria->compare('birthday',$this->birthday,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
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
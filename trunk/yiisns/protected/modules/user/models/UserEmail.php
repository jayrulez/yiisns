<?php

/**
 * This is the model class for table "yiisns.user_email".
 *
 * The followings are the available columns in table 'yiisns.user_email':
 * @property string $id
 * @property string $user_id
 * @property string $email_address
 * @property integer $confirmed
 * @property string $create_time
 *
 * The followings are the available model relations:
 * @property User[] $users
 * @property User $user
 * @property UserEmailConfirmRequest[] $userEmailConfirmRequests
 */
class UserEmail extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserEmail the static model class
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
		return 'yiisns.user_email';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, email_address, confirmed, create_time', 'required'),
			array('confirmed', 'numerical', 'integerOnly'=>true),
			array('user_id, create_time', 'length', 'max'=>10),
			array('email_address', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, email_address, confirmed, create_time', 'safe', 'on'=>'search'),
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
			'users' => array(self::HAS_MANY, 'User', 'primary_email_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'userEmailConfirmRequests' => array(self::HAS_MANY, 'UserEmailConfirmRequest', 'email_id'),
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
			'email_address' => 'Email Address',
			'confirmed' => 'Confirmed',
			'create_time' => 'Create Time',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('email_address',$this->email_address,true);
		$criteria->compare('confirmed',$this->confirmed);
		$criteria->compare('create_time',$this->create_time,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
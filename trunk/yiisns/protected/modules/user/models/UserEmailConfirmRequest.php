<?php

/**
 * This is the model class for table "yiisns.user_email_confirm_request".
 *
 * The followings are the available columns in table 'yiisns.user_email_confirm_request':
 * @property string $user_id
 * @property string $email_id
 * @property string $code
 * @property string $create_time
 */
class UserEmailConfirmRequest extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserEmailConfirmRequest the static model class
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
		return 'yiisns.user_email_confirm_request';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, email_id, code, create_time', 'required'),
			array('user_id, email_id, create_time', 'length', 'max'=>10),
			array('code', 'length', 'max'=>32),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, email_id, code, create_time', 'safe', 'on'=>'search'),
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
			'email' => array(self::BELONGS_TO, 'UserEmail', 'email_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'email_id' => 'Email',
			'code' => 'Code',
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

		$criteria->compare('user_id',$this->user_id,true);

		$criteria->compare('email_id',$this->email_id,true);

		$criteria->compare('code',$this->code,true);

		$criteria->compare('create_time',$this->create_time,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
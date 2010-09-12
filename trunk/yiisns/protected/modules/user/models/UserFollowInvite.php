<?php

/**
 * This is the model class for table "yiisns.user_follow_invite".
 *
 * The followings are the available columns in table 'yiisns.user_follow_invite':
 * @property string $user_id
 * @property string $inviter_id
 * @property integer $status
 * @property string $create_time
 *
 * The followings are the available model relations:
 * @property User $inviter
 * @property User $user
 */
class UserFollowInvite extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserFollowInvite the static model class
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
		return 'yiisns.user_follow_invite';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, inviter_id, status, create_time', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('user_id, inviter_id, create_time', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, inviter_id, status, create_time', 'safe', 'on'=>'search'),
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
			'inviter' => array(self::BELONGS_TO, 'User', 'inviter_id'),
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
			'inviter_id' => 'Inviter',
			'status' => 'Status',
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
		$criteria->compare('inviter_id',$this->inviter_id,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('create_time',$this->create_time,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
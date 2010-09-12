<?php

/**
 * This is the model class for table "yiisns.user".
 *
 * The followings are the available columns in table 'yiisns.user':
 * @property string $id
 * @property string $primary_email_id
 * @property string $username
 * @property string $password
 * @property integer $status
 * @property string $location_id
 * @property string $create_ip
 * @property string $create_time
 * @property string $update_time
 * @property string $active_time
 *
 * The followings are the available model relations:
 * @property AuthItem[] $authItems
 * @property Post[] $posts
 * @property PostComment[] $postComments
 * @property Location $location
 * @property UserEmail $primaryEmail
 * @property UserEmail[] $userEmails
 * @property UserEmailConfirmRequest[] $userEmailConfirmRequests
 * @property UserFollow[] $userFollows
 * @property UserFollowInvite[] $userFollowInvites
 * @property UserFollowRequest[] $userFollowRequests
 * @property Location[] $locations
 * @property UserLoginLog[] $userLoginLogs
 * @property UserPasswordResetRequest[] $userPasswordResetRequests
 * @property UserProfile $userProfile
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return User the static model class
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
		return 'yiisns.user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, status, create_time', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('primary_email_id, location_id, create_time, update_time, active_time', 'length', 'max'=>10),
			array('username, password', 'length', 'max'=>32),
			array('create_ip', 'length', 'max'=>39),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, primary_email_id, username, password, status, location_id, create_ip, create_time, update_time, active_time', 'safe', 'on'=>'search'),
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
			'authItems' => array(self::MANY_MANY, 'AuthItem', 'auth_assignment(userid, itemname)'),
			'posts' => array(self::MANY_MANY, 'Post', 'post_mention(user_id, post_id)'),
			'postComments' => array(self::MANY_MANY, 'PostComment', 'post_comment_mention(user_id, comment_id)'),
			'location' => array(self::BELONGS_TO, 'Location', 'location_id'),
			'primaryEmail' => array(self::BELONGS_TO, 'UserEmail', 'primary_email_id'),
			'userEmails' => array(self::HAS_MANY, 'UserEmail', 'user_id'),
			'userEmailConfirmRequests' => array(self::HAS_MANY, 'UserEmailConfirmRequest', 'user_id'),
			'userFollows' => array(self::HAS_MANY, 'UserFollow', 'user_id'),
			'userFollowInvites' => array(self::HAS_MANY, 'UserFollowInvite', 'user_id'),
			'userFollowRequests' => array(self::HAS_MANY, 'UserFollowRequest', 'user_id'),
			'locations' => array(self::MANY_MANY, 'Location', 'user_location_alias(user_id, location_id)'),
			'userLoginLogs' => array(self::HAS_MANY, 'UserLoginLog', 'user_id'),
			'userPasswordResetRequests' => array(self::HAS_MANY, 'UserPasswordResetRequest', 'user_id'),
			'userProfile' => array(self::HAS_ONE, 'UserProfile', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'primary_email_id' => 'Primary Email',
			'username' => 'Username',
			'password' => 'Password',
			'status' => 'Status',
			'location_id' => 'Location',
			'create_ip' => 'Create Ip',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'active_time' => 'Active Time',
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
		$criteria->compare('primary_email_id',$this->primary_email_id,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('location_id',$this->location_id,true);
		$criteria->compare('create_ip',$this->create_ip,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('active_time',$this->active_time,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
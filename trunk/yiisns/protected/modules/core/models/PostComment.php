<?php

/**
 * This is the model class for table "yiisns.post_comment".
 *
 * The followings are the available columns in table 'yiisns.post_comment':
 * @property string $id
 * @property string $user_id
 * @property string $post_id
 * @property string $content
 * @property string $create_time
 *
 * The followings are the available model relations:
 * @property Post $post
 * @property User $user
 * @property User[] $users
 */
class PostComment extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return PostComment the static model class
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
		return 'yiisns.post_comment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, post_id, content, create_time', 'required'),
			array('user_id, post_id, create_time', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, post_id, content, create_time', 'safe', 'on'=>'search'),
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
			'post' => array(self::BELONGS_TO, 'Post', 'post_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'users' => array(self::MANY_MANY, 'User', 'post_comment_mention(comment_id, user_id)'),
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
			'post_id' => 'Post',
			'content' => 'Content',
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
		$criteria->compare('post_id',$this->post_id,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('create_time',$this->create_time,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
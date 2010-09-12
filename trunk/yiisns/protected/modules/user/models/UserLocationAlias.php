<?php

/**
 * This is the model class for table "yiisns.user_location_alias".
 *
 * The followings are the available columns in table 'yiisns.user_location_alias':
 * @property string $user_id
 * @property string $location_id
 * @property string $alias
 *
 * The followings are the available model relations:
 */
class UserLocationAlias extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserLocationAlias the static model class
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
		return 'yiisns.user_location_alias';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, location_id, alias', 'required'),
			array('user_id, location_id', 'length', 'max'=>10),
			array('alias', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, location_id, alias', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'location_id' => 'Location',
			'alias' => 'Alias',
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
		$criteria->compare('location_id',$this->location_id,true);
		$criteria->compare('alias',$this->alias,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
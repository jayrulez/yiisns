<?php

/**
 * This is the model class for table "yiisns.contact_aspect".
 *
 * The followings are the available columns in table 'yiisns.contact_aspect':
 * @property string $user_id
 * @property string $contact_id
 * @property string $aspect_id
 *
 * The followings are the available model relations:
 * @property Aspect $aspect
 * @property Contact $user
 * @property Contact $contact
 */
class ContactAspect extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ContactAspect the static model class
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
		return 'yiisns.contact_aspect';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, contact_id, aspect_id', 'required'),
			array('user_id, contact_id, aspect_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, contact_id, aspect_id', 'safe', 'on'=>'search'),
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
			'aspect' => array(self::BELONGS_TO, 'Aspect', 'aspect_id'),
			'user' => array(self::BELONGS_TO, 'Contact', 'user_id'),
			'contact' => array(self::BELONGS_TO, 'Contact', 'contact_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'contact_id' => 'Contact',
			'aspect_id' => 'Aspect',
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
		$criteria->compare('contact_id',$this->contact_id,true);
		$criteria->compare('aspect_id',$this->aspect_id,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
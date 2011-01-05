<?php

/**
 * This is the model class for table "contact".
 *
 * The followings are the available columns in table 'contact':
 * @property string $user_id
 * @property string $contact_id
 *
 * The followings are the available model relations:
 * @property User $contact
 * @property User $user
 * @property Aspect[] $aspects
 */
class Contact extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Contact the static model class
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
		return 'contact';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, contact_id', 'required'),
			array('user_id, contact_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, contact_id', 'safe', 'on'=>'search'),
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
			'contact' => array(self::BELONGS_TO, 'User', 'contact_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'aspects' => array(self::HAS_MANY, 'Aspect', 'contact_aspect(user_id, contact_id, aspect_id)'),
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

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public function getIsInversed()
	{
		$inversed = Contact::model()->findByAttributes(array(
			'user_id'=>$this->contact_id,
			'contact_id'=>$this->user_id,
		));
		
		return $inversed !== null;
	}
	
	public function delete()
	{
		$status = parent::delete();
		
		$inversed = Contact::model()->findByAttributes(array(
			'user_id'=>$this->contact_id,
			'contact_id'=>$this->user_id,
		));
		
		if($inversed !== null)
		{
			$inversed->delete();
		}
		
		return $status;
	}
	
	public function save($runValidation=true, $attributes=NULL)
	{
		$status = parent::save($runValidation, $attributes);
		
		if(!$this->getIsInversed()/* && this->getIsNewRecord()*/)
		{
			$inversed = new Contact;
			$inversed->user_id = $this->contact_id;
			$inversed->contact_id = $this->user_id;
			$inversed->save(false);
		}
		
		return $status;
	}
}
<?php

class Contact extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'contact';
	}

	public function rules()
	{
		return array(
			array('user_id, contact_id', 'required'),
			array('user_id, contact_id', 'length', 'max'=>11),
		);
	}

	public function relations()
	{
		return array(
			'contact' => array(self::BELONGS_TO, 'User', 'contact_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'aspects' => array(self::HAS_MANY, 'Aspect', 'contact_aspect(user_id, contact_id, aspect_id)'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'contact_id' => 'Contact',
		);
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
	
	public function afterSave()
	{
	
	}
}
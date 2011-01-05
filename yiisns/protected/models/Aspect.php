<?php

/**
 * This is the model class for table "aspect".
 *
 * The followings are the available columns in table 'aspect':
 * @property string $id
 * @property string $user_id
 * @property string $name
 * @property string $create_time
 * @property string $update_time
 *
 * The followings are the available model relations:
 * @property User $user
 * @property Contact[] $contacts
 * @property Post[] $posts
 */
class Aspect extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Aspect the static model class
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
		return 'aspect';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('name', 'length', 'min'=>3, 'max'=>32),
			array('name', 'uniqueOnUserId'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, name, create_time, update_time', 'safe', 'on'=>'search'),
		);
	}

	public function uniqueOnUserId($attribute, $params = array())
	{
		$aspect = Aspect::model()->findByAttributes(array(
			'user_id'=>$this->user_id,
			'name'=>$this->name,
		));
		
		if($aspect !== null && $aspect->id !== $this->id)
		{
			$this->addError('name', Yii::t('application', 'You already have an aspect named "{name}".', array(
				'{name}'=>$this->name,
			)));
		}
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
			'contacts' => array(self::MANY_MANY, 'Contact', 'contact_aspect(user_id, contact_id, aspect_id)'),
			'posts' => array(self::MANY_MANY, 'Post', 'post_aspect(aspect_id, post_id)'),
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
			'name' => 'Name',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public function getUrl()
	{
		return Yii::app()->createUrl('/aspect/view', array(
			'id'=>$this->id,
		));
	}
	
	public function getLink($htmlOptions = array())
	{
		return CHtml::link($this->name, $this->getUrl(), $htmlOptions);
	}
	
	public function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->getIsNewRecord())
			{
				$this->create_time = time();
			}else{
				$this->update_time = time();
			}
			return true;
		}
		
		return false;
	}
	
	public function getContactCount()
	{
		$contacts = $this->dbConnection->createCommand("SELECT * FROM contact_aspect WHERE user_id=:user_id AND aspect_id=:aspect_id")->bindValues(array(
			':user_id'=>$this->user->id,
			':aspect_id'=>$this->id,
		))->queryAll();
		
		return count($contacts);
	}
}
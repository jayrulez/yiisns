<?php

/**
 * This is the model class for table "post".
 *
 * The followings are the available columns in table 'post':
 * @property string $id
 * @property string $user_id
 * @property string $content
 * @property string $create_time
 * @property string $update_time
 *
 * The followings are the available model relations:
 * @property Comment[] $comments
 * @property User $user
 * @property Aspect[] $aspects
 */
class Post extends CActiveRecord
{
	const ALL_ASPECTS = ':all';
	/**
	 * Returns the static model of the specified AR class.
	 * @return Post the static model class
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
		return 'post';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('content', 'required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, content, create_time, update_time', 'safe', 'on'=>'search'),
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
			'comments' => array(self::HAS_MANY, 'Comment', 'post_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'aspects' => array(self::MANY_MANY, 'Aspect', 'post_aspect(post_id, aspect_id)'),
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
			'content' => 'Content',
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
		$criteria->compare('content',$this->content,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public function getUrl()
	{
		return Yii::app()->createUrl('/post/view', array(
			'id'=>$this->id,
		));
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
	
	public function getIsInAspect($aspectId, $dbConnection = null)
	{
		if($dbConnection === null)
		{
			$dbConnection = $this->dbConnection;
		}
		$rows = $dbConnection->createCommand("SELECT COUNT(*) FROM post_aspect WHERE post_id=:post_id AND aspect_id=:aspect_id")->bindValues(array(
			':post_id'=>$this->id,
			':aspect_id'=>$aspectId,
		))->queryAll();
		
		return count($rows);
	}
	
	public function addToAspect($aspectId, $dbConnection = null)
	{
		if($dbConnection === null)
		{
			$dbConnection = $this->dbConnection;
		}
		
		$insert = $dbConnection->createCommand("INSERT INTO post_aspect VALUES(:post_id, :aspect_id)")->bindValues(array(
			':post_id'=>$this->id,
			':aspect_id'=>$aspectId,
		))->execute();
		
		return $insert;
	}
	
	public function addToAspects($aspectIds, $dbConnection = null)
	{
		if(!is_array($aspectIds))
		{
			if($aspectIds === self::ALL_ASPECTS)
			{
				$aspectIds = $this->user->getAspectIds();
			}else{
				$aspectIds = array($aspectIds);
			}
		}
		
		foreach($aspectIds as $aspectId)
		{
			$this->addToAspect($aspectId, $dbConnection);
		}
	}
	
	public function removeFromAspect($aspectId, $dbConnection = null)
	{
		if($dbConnection === null)
		{
			$dbConnection = $this->dbConnection;
		}
		
		$delete = $dbConnection->createCommand("DELETE FROM post_aspect WHERE post_id=:post_id AND aspect_id=:aspect_id")->bindValues(array(
			':post_id'=>$this->id,
			':aspect_id'=>$aspectId,
		))->execute();
		
		return $delete;
	}
	
	public function getShortenedContent($length = 20)
	{
		return Util::shortenString($this->content, $length);
	}
}
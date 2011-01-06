<?php

class Post extends CActiveRecord
{
	const ALL_ASPECTS = ':all';

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'post';
	}

	public function rules()
	{
		return array(
			array('content', 'required'),
		);
	}

	public function relations()
	{
		return array(
			'comments' => array(self::HAS_MANY, 'Comment', 'post_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'aspects' => array(self::MANY_MANY, 'Aspect', 'post_aspect(post_id, aspect_id)'),
		);
	}

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
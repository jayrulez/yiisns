<?php

class PhotoAlbum extends CActiveRecord
{
	const TYPE_PROFILE = 'profile';
	const TYPE_USER = 'user';
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'photo_album';
	}

	public function rules()
	{
		return array(
			array('name', 'required'),
			array('cover_photo_id', 'length', 'max'=>11),
			array('name', 'length', 'max'=>255),
			array('caption','safe'),
		);
	}

	public function relations()
	{
		return array(
			'photos' => array(self::HAS_MANY, 'Photo', 'photo_album_id'),
			'coverPhoto' => array(self::BELONGS_TO, 'Photo', 'cover_photo_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'type' => 'Type',
			'name' => 'Name',
			'cover_photo_id' => 'Cover Photo',
			'caption' => 'Caption',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
		);
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
	
	public static function getTypes()
	{
		return array(self::TYPE_PROFILE, self::TYPE_USER);
	}
	
	public function addPhoto($userId, $filePath)
	{
		$photo = new Photo;
		$photo->user_id = $userId;
		$photo->photo_album_id = $this->id;
		$photo->file_path = $filePath;
		$saved = $photo->save();
		if($saved)
		{
			if(count($this->photos) === 1)
			{
				$this->saveAttributes(array(
					'cover_photo_id'=>$photo->id,
				));
			}
			return $photo;
		}
		return null;
	}
	
	public function getPath()
	{
		return Environment::getPhotoAlbumPath($this->user->id, $this->id);
	}
	
	public function getDir()
	{
		return Environment::getPhotoAlbumDir($this->user->id, $this->id);
	}
}
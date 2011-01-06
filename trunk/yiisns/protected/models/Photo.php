<?php

class Photo extends CActiveRecord
{
	/*max size of photo in bytes*/
	const MAX_FILE_SIZE = 4193404; // 4mb
	
	const SIZE_MICRO = 0;
	const SIZE_MINI = 1;
	const SIZE_SMALL = 2;
	const SIZE_MEDIUM = 3;
	const SIZE_LARGE = 4;
	const SIZE_ORIGINAL = 5;
	
	public static function getSizes()
	{
		return array(
			self::SIZE_MICRO=>array(
				'width'=>15,
				'height'=>15,
			),
			self::SIZE_MINI=>array(
				'width'=>30,
				'height'=>30,
			),
			self::SIZE_SMALL=>array(
				'width'=>48,
				'height'=>48,
			),
			self::SIZE_MEDIUM=>array(
				'width'=>170,
				'height'=>170,
			),
			self::SIZE_LARGE=>array(
				'width'=>250,
				'height'=>250,
			),
			self::SIZE_ORIGINAL=>array(),
		);
	}
	
	public static function getSizeAsString($size)
	{
		$sizes = self::getSizes();
		if(array_key_exists($size, $sizes))
		{
			$size = $sizes[$size];
			$width = isset($size['width']) ? $size['width'] : '';
			$height = isset($size['height']) ? $size['height'] : '';
			return (!empty($width) && !empty($height)) ? $width.'x'.$height : '';
		}else{
			throw new CException(Yii::t('application','Invalid Photo::SIZE_...'));
		}
	}
	
	public static function getSize($size)
	{
		$sizes = self::getSizes();
		
		return isset($sizes[$size]) ? $sizes[$size] : array();
	}
	
	public function getPathOfSize($size)
	{
		$sizeString = self::getSizeAsString($size);
		$extension = substr($this->file_path, -3, strlen($this->file_path));

		return str_replace('.'.$extension, $sizeString.'.'.$extension, $this->file_path);
	}
	
	public function getSrcAsSize($size)
	{
		
		$filePath = $this->getPathOfSize($size);
		
		if(!file_exists($filePath))
		{
			if(!$this->makeSize($size))
			{
				return null;
			}
		}
		
		return Yii::app()->getBaseUrl().'/'.$filePath;
	}
	
	public function makeSize($size)
	{
		if(!file_exists($this->file_path))
		{
			return false;
		}
		
		Yii::import('lib.flourishlib.classes.*');
		$original = new fImage($this->file_path);
		$newImage = fImage::create($this->getPathOfSize($size), $original->read());
		$height = $newImage->getHeight();
		$width = $newImage->getWidth();
		$size = self::getSize($size);
		if($height > $width)
		{
			$newImage->resize(0, $size['height']);
		}else{
			$newImage->resize($size['width'], 0);
		}
		$newImage->cropToRatio($size['width'], $size['height']);
		$newImage->resize($size['width'], $size['height'], true);
		$newImage->saveChanges(null, 100);
		return true;
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'photo';
	}

	public function rules()
	{
		return array(
			array('file_path', 'required'),
			array('photo_album_id', 'length', 'max'=>11),
			array('file_path', 'length', 'max'=>255),
		);
	}

	public function relations()
	{
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'photoAlbum' => array(self::BELONGS_TO, 'PhotoAlbum', 'photo_album_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'photo_album_id' => 'Photo Album',
			'file_path' => 'File Path',
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
	
	public function getUrl()
	{
		return Yii::app()->getBaseUrl().'/'.$this->file_path;
	}
}
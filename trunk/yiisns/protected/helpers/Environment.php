<?php

class Environment
{
	const UPLOAD_DIR = 'uploads';
	
	public static function getUploadDir()
	{
		$dir = self::UPLOAD_DIR;
		if(!is_dir($dir))
		{
			@mkdir($dir, 777);
		}
		return $dir;
	}
	
	public static function getUploadPath()
	{
		$path = self::getUploadDir();
		return realpath($path);
	}
	
	public static function getUserDir($userId=null)
	{
		$dir = self::getUploadDir().'/user';
		if($userId!==null)
		{
			$dir .= '/'.$userId;
		}
		if(!is_dir($dir))
		{
			@mkdir($dir, 777, true);
		}
		return $dir;
	}
	
	public static function getUserPath($userId=null)
	{
		$path = self::getUserDir($userId);
		return realpath($path);
	}
	
	public static function getPhotoAlbumDir($userId, $albumId=null)
	{
		$dir = self::getUserDir($userId).'/album';
		if($albumId!==null)
		{
			$dir .= '/'.$albumId;
		}
		if(!is_dir($dir))
		{
			@mkdir($dir, 777, true);
		}
		return $dir;
	}
	
	public static function getPhotoAlbumPath($userId, $albumId=null)
	{
		$path = self::getPhotoAlbumDir($userId, $albumId);
		return realpath($path);
	}
}
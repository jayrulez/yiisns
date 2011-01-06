<?php

class PhotoUploadForm extends CFormModel
{
	public $file;

	public function rules()
	{
		return array(
			array('file', 'required'),
			array('file','file','types'=>'jpg, png, gif','maxSize'=>Photo::MAX_FILE_SIZE),
		);
	}
	
	public function process()
	{
		return true;
	}
	
	public function attributeLabels()
	{
		return array(
			'file'=>Yii::t('application', 'Select an image file'),
		);
	}
}
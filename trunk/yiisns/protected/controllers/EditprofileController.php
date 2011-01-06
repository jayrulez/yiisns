<?php

class EditprofileController extends Controller
{
	public $defaultAction = 'basic';
	
	public function accessRules()
	{
		return array(
			array(
				'allow',
				'actions'=>array(
					'basic','picture',
				),
				'users'=>array('@'),
			),
			array(
				'deny',
				'actions'=>array(
					'basic','picture',
				),
				'users'=>array('*'),
			),
		);
	}
	
	public function actionBasic()
	{	
		$user = Yii::app()->getUser()->getModel();
		
		$profile = $user->profile === null ? new Profile : $user->profile;
		
		if(($post = Yii::app()->getRequest()->getPost('Profile')) !== null)
		{
			$profile->attributes = $post;
			
			if(!$profile->save())
			{
			
			}
		}
		
		$this->render('basic', array(
			'profile'=>$profile,
		));
	}
	
	public function actionPicture()
	{
		$user = Yii::app()->getUser()->getModel();
		
		if($user->profile === null)
		{
			$this->redirect(array('/editprofile/basic'));
		}
		
		$photoUploadForm = new PhotoUploadForm;
		
		if(($post=Yii::app()->getRequest()->getPost('PhotoUploadForm')) !== null)
		{
			$file = $photoUploadForm->file = CUploadedFile::getInstance($photoUploadForm, 'file');
			
			if($photoUploadForm->validate())
			{
				if($user->getProfilePhotoAlbum() === null)
				{
					if(!$user->addProfilePhotoAlbum())
					{
						throw new CException(Yii::t('application','You do not have a "Profile Picture" album and the system was unable to create one for you.'));
					}
				}

				$photoAlbum = $user->getProfilePhotoAlbum();
				
				$filePath = $photoAlbum->getPath().'/'.uniqid().$user->id.md5($file->getName()).'.'.$file->getExtensionName();
				$savePath = $filePath;
				
				if($file->saveAs($savePath) && (($photo = $photoAlbum->addPhoto($user->id, $filePath)) !== null))
				{
					$user->profile->saveAttributes(array(
						'photo_id'=>$photo->id,
					));
				}else{
					throw new CException(Yii::t('application','Unable to save your profile picture.'));
				}
			}
		}
		
		$this->render('picture', array(
			'form'=>$photoUploadForm,
		));
	}
}
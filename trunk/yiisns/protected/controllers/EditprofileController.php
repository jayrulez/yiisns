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
	
	public function init()
	{
		parent::init();
		Layout::addBlock('sidebar.right', array(
			'id'=>'right_sidebar',
			'content'=>$this->renderPartial('/partial/editprofile_right', array('user'=>Yii::app()->getUser()->getModel()), true),
		));
	}
	
	public function actionBasic()
	{	
		$user = Yii::app()->getUser()->getModel();
		
		$profile = $user->profile === null ? new Profile : $user->profile;
		
		if($profile->getIsNewRecord())
		{
			$profile->user_id = $user->id;
		}
		
		if(($post = Yii::app()->getRequest()->getPost('Profile')) !== null)
		{
			$profile->attributes = $post;
			
			if($profile->save())
			{
				Yii::app()->getUser()->setFlash('success',Yii::t('application','Your changes have been saved.'));
			}
		}
		
		$this->render('basic', array(
			'model'=>$profile,
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
				
				$filePath = $photoAlbum->getDir().'/'.Photo::generateName($file->getName(), $file->getExtensionName(), $user->id);
				
				$savePath = $filePath;
				
				if($file->saveAs($savePath)===true && (($photo = $photoAlbum->addPhoto($user->id, $filePath)) !== null))
				{
					$user->profile->saveAttributes(array(
						'photo_id'=>$photo->id,
					));
					Yii::app()->getUser()->setFlash('success',Yii::t('application','Your changes have been saved.'));
				}else{
					throw new CException(Yii::t('application','Unable to save your profile picture.'));
				}
			}
		}
		
		$this->render('picture', array(
			'form'=>$photoUploadForm,
			'user'=>$user,
		));
	}
}
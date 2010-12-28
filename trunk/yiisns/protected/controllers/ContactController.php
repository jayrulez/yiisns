<?php

class ContactController extends Controller
{	
	public $defaultAction = 'view';
	
	public function accessRules()
	{
		return array(
			array(
				'allow',
				'actions'=>array(
					'create','view','delete','sendRequest','sentRequests',
				),
				'users'=>array('@'),
			),
			array(
				'deny',
				'actions'=>array(
					'create','view','delete','sendRequest','sentRequests',
				),
				'users'=>array('*'),
			),
		);
	}
	
	public function actionCreate()
	{
	
	}
	
	public function actionView()
	{
	
	}
	
	public function actionDelete()
	{
		$contact = Contact::model()->findByAttributes(array(
			'user_id'=>Yii::app()->user->getId(),
			'contact_id'=>Yii::app()->request->getParam('id'),
		));
		
		$userLink = $contact->contact->getUrl();
		
		if($contact !== null)
		{
			$contact->delete();
		}
		
		$this->redirect($userLink);
	}
	
	public function actionSendRequest()
	{
		$user = User::model()->findByPk(Yii::app()->request->getParam('id'));
		
		if($user === null || $user->id === Yii::app()->user->getId())
		{
			throw new CHttpException(404, Yii::t('application', 'The user you are trying to add as a contact is not available.'));
		}
		
		if(Util::areContacts(Yii::app()->user->getId(), $user->id))
		{
			throw new CException(401, Yii::t('application', 'You and {username} are already contacts.', array(
				'{username}'=>$user->username,
			)));
		}
		
		$request = new Request;
		$request->user_id = Yii::app()->user->getId();
		$request->contact_id = $user->id;
		
		if($request->save())
		{
			$this->redirect($user->getUrl());
		}else{
			// do something, let user know that request failed
		}
	}
	
	public function actionSentRequests()
	{
		$sentRequests = (($user=Yii::app()->user->getModel()) !== null) ? $user->sentRequests : array();
		
		$this->render('sentRequests', array(
			'sentRequests'=>$sentRequests,
		));
	}
	
	public function actionDeleteRequest()
	{
		$request = Request::model()->findByAttributes(array(
			'user_id'=>Yii::app()->request->getParam('user_id'),
			'contact_id'=>Yii::app()->request->getParam('contact_id'),
		));
		
		if($request === null || !($request->user_id===Yii::app()->user->getId()||$request->contact_id===Yii::app()->user->getId()))
		{
			throw new CHttpException(404, Yii::t('application', 'The requested page does not exist.'));
		}
		
		$request->delete();
		
		$this->redirect(Yii::app()->user->returnUrl);
	}
	
	public function actionConfirmRequest()
	{
		$request = Request::model()->findByAttributes(array(
			'user_id'=>Yii::app()->request->getParam('user_id'),
			'contact_id'=>Yii::app()->request->getParam('contact_id'),
		));
		
		if($request === null || $request->contact_id !== Yii::app()->user->getId())
		{
			throw new CHttpException(404, Yii::t('application', 'The requested page does not exist.'));
		}
		
		$userLink = $request->user->getUrl();
		
		$contact = new Contact;
		$contact->user_id = $request->user_id;
		$contact->contact_id = $request->contact_id;
		
		if($contact->save())
		{
			$request->delete();
		}
		
		$this->redirect($userLink);
	}
	
	public function actionRequests()
	{
		$requests = (($user=Yii::app()->user->getModel()) !== null) ? $user->requests : array();;
		
		$this->render('requests', array(
			'requests'=>$requests,
		));
	}
	
	public function actionManage()
	{
		$this->render('manage');
	}
}
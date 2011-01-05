<?php

class ContactController extends Controller
{
	public function accessRules()
	{
		return array(
			array(
				'allow',
				'actions'=>array(
					'add','confirm','delete','delete','requests','manage',
				),
				'users'=>array('@'),
			),
			array(
				'deny',
				'actions'=>array(
					'add','confirm','delete','delete','requests','manage',
				),
				'users'=>array('*'),
			),
		);
	}
	
	public function actionAdd()
	{
		$user = User::model()->findByPk(Yii::app()->request->getParam('id'));
		
		if($user === null || $user->id === Yii::app()->getUser()->getId())
		{
			throw new CHttpException(404, Yii::t('application', 'The user you are trying to add as a contact is not available.'));
		}
		
		if(User::areContacts(Yii::app()->getUser()->getId(), $user->id))
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
			throw new CException(Yii::t('application', 'Write error message here'));
		}
	}
	
	public function actionConfirm()
	{
		$request = Request::model()->findByAttributes(array(
			'user_id'=>Yii::app()->getRequest()->getParam('user_id'),
			'contact_id'=>Yii::app()->getRequest()->getParam('contact_id'),
		));
		
		if($request === null || $request->contact_id !== Yii::app()->getUser()->getId())
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
			$this->redirect($userLink);
		}else{
			throw new CException(Yii::t('application', 'Write error message here'));
		}
	}
	
	public function actionDeleteRequest()
	{
		$request = Request::model()->findByAttributes(array(
			'user_id'=>Yii::app()->getRequest()->getParam('user_id'),
			'contact_id'=>Yii::app()->getRequest()->getParam('contact_id'),
		));
		
		if($request === null || !($request->user_id===Yii::app()->getUser()->getId()||$request->contact_id===Yii::app()->getUser()->getId()))
		{
			throw new CHttpException(404, Yii::t('application', 'The requested page does not exist.'));
		}
		
		$request->delete();
		
		$this->redirect(Yii::app()->getUser()->returnUrl);
	}
	
	public function actionDelete()
	{
		$contact = Contact::model()->findByAttributes(array(
			'user_id'=>Yii::app()->getUser()->getId(),
			'contact_id'=>Yii::app()->getRequest()->getParam('id'),
		));

		if($contact !== null)
		{
			$userLink = $contact->contact->getUrl();
			$contact->delete();
			$this->redirect($userLink);
		}else{
			throw new CHttpException(404, Yii::t('application', 'Write error message here'));
		}
	}
	
	public function actionRequests()
	{
		$user=Yii::app()->user->getModel();
		
		$types = Request::getTypes();
		
		$type = Yii::app()->getRequest()->getQuery('type',Request::TYPE_RECEIVED);
		
		$type = in_array($type, $types) ? $type : Request::TYPE_RECEIVED;
		
		$requests = ($type === Request::TYPE_RECEIVED) ? $user->requestsReceived : $user->requestsSent;
		
		$this->render('requests', array(
			'requests'=>$requests,
			'type'=>$type,
		));
	}
	
	public function actionManage()
	{
		$this->render('manage');
	}
}
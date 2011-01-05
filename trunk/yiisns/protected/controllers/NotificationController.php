<?php

class NotificationController extends Controller
{
	public function accessRules()
	{
		return array(
			array(
				'allow',
				'actions'=>array(
					'index','view','delete',
				),
				'users'=>array('@'),
			),
			array(
				'deny',
				'actions'=>array(
					'index','view','delete',
				),
				'users'=>array('*'),
			),
		);
	}
	
	public function actionIndex()
	{
		$this->render('index');
	}
	
	public function actionView()
	{	
		$notification = $this->loadNotification(Yii::app()->getRequest()->getParam('id'));
		
		$this->render('view', array(
			'notification'=>$notification,
		));
	}
	
	public function actionDelete()
	{
		$notification = $this->loadNotification(Yii::app()->getRequest()->getParam('id'));
		
		$notification->delete();
		
		$this->redirect(array('/notification/index'));
	}
	
	public function loadNotification($notificationId)
	{
		$notification = Notification::model()->findByPk($notificationId);
			
		if($notification === null || $notification->user_id !== Yii::app()->getUser()->getModel()->id)
		{
			throw new CHttpException(404,Yii::t('application','The requested page does not exist.'));
		}else{
			return $notification;
		}
	}
}
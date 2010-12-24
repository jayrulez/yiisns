<?php

class CommentController extends Controller
{	
	public $defaultAction = 'view';
	
	public function accessRules()
	{
		return array(
			array(
				'allow',
				'actions'=>array(
					'create','view','delete',
				),
				'users'=>array('@'),
			),
			array(
				'deny',
				'actions'=>array(
					'create','view','delete',
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
	
	}
}
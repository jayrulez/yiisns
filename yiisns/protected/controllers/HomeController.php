<?php

class HomeController extends Controller
{
	public function accessRules()
	{
		return array();
	}
	
	public function actionIndex()
	{
	    $this->render('index');
	}
}
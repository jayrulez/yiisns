<?php

class HeaderWidget extends CWidget
{
	public function init()
	{
	}
	
	public function run()
	{
		if(($user = Yii::app()->user->getModel()) === null)
		{
			$this->render('guestHeader');
		}else{
			$this->render('header');
		}
	}
}
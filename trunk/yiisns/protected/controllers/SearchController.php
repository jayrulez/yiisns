<?php

class SearchController extends Controller
{
	public function accessRules()
	{
		return array();
	}
	
	public function actionIndex()
	{
		$results = array();
		
		$searchType = Yii::app()->request->getParam('search_type')!== null ? array(Yii::app()->request->getParam('search_type')) : array('users', 'posts');
		
		if(in_array('users', $searchType))
		{
			$criteria = new CDbCriteria;
			$criteria->addSearchCondition('username', Yii::app()->request->getParam('q'));
			$users = User::model()->findAll($criteria);
			
			if(count($users))
			{
				$results['users'] = $users;
			}
		}
		
		if(in_array('posts', $searchType))
		{
		}
		
		$this->render('index', array(
			'results'=>$results,
			'q'=>Yii::app()->request->getParam('q'),
		));
	}
}
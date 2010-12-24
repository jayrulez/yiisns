<?php

class PostController extends Controller
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
	
	/*This action may need to be refactored*/
	public function actionCreate()
	{		
		$errors = array('post'=>array(),'aspects'=>array(),'post_aspect'=>array());
		
		if(($_post=Yii::app()->request->getPost('Post')) !== null)
		{
			$post = new Post;
			
			$post->attributes = $_post;
			
			$post->user_id = Yii::app()->user->getId();
			
			if($post->save())
			{
				if(($aspects = Yii::app()->request->getPost('aspects')) !== null && is_array($aspects) && count($aspects))
				{
					foreach($aspects as $aspectId)
					{
						$aspect = Aspect::model()->findByPk($aspectId);
						
						if($aspect === null || $aspect->user->id !== Yii::app()->user->getId())
						{
							$errors['aspects'][] = Yii::t('application', 'You do not have an aspect named {aspectName}.', array(
								'{aspectName}'=>$aspect->name
							));
						}else{
							$postAspect = new PostAspect;
							$postAspect->post_id = $post->id;
							$postAspect->aspect_id = $aspect->id;
							if(!$postAspect->save())
							{
								$errors['post_aspect'][] = $postAspect->getErrors();
							}
						}
					}
				}
			}else{
				$errors['post'] = $post->getErrors();
			}
			
			/*$aspectId=Yii::app()->request->getPost('aspect_id');
			
			if($aspectId !== null)
			{
				$aspect = Aspect::model()->findByPk($aspectId);
				
				if($aspect === null || $aspect->user->id !== Yii::app()->user->getId())
				{
					throw new CHttpException(403, Yii::t('application', 'You are not authorized to post to this aspect.'));
				}else{
					if($post->save())
					{
						$postAspect = new PostAspect;
						$postAspect->post_id = $post->id;
						$postAspect->aspect_id = $aspectId;
						$postAspect->save(false);
						
						$this->redirect(array('/aspect/view', 'id'=>$aspect->id));
						Yii::app()->end();
					}else{
						// do something
					}
				}
			}else{
				if($post->save())
				{
					$this->redirect(array('/home'));
				}else{
					// do something
				}
			}*/
		}
		// do something with errors so users can see, maybe view flash?
		$this->redirect(Yii::app()->user->returnUrl);
	}
	
	public function actionView()
	{
		$post = Post::model()->findByPk(Yii::app()->request->getQuery('id'));
		
		/*if($post === null || !Util::canSeePost(Yii::app()->user->getId(), $post->id))
		{
			throw new CHttpException(Yii::t('application', 'The requested page does not exist.'));
		}*/
		
		$this->render('view', array(
			'post'=>$post,
		));
	}
	
	public function actionDelete()
	{
	
	}
}
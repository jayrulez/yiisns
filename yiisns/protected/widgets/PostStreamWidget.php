<?php

class PostStreamWidget extends CWidget
{	
	public $aspectId = null;
	
	public function init()
	{
		Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/postStream.css');
	}
	
	public function run()
	{
		$posts = array();
		
		if($this->aspectId !== null)
		{
			$posts = Post::model()->findAllBySql("SELECT * 
				FROM post 
				WHERE (post.user_id=:user_id 
				AND post.id IN (SELECT post_id FROM post_aspect WHERE aspect_id=:aspect_id)) 
				OR post.id IN (SELECT pa.post_id 
					FROM post_aspect as pa inner join contact_aspect as ca ON ca.aspect_id=pa.aspect_id 
					WHERE ca.contact_id=:user_id AND ca.user_id IN (SELECT contact_id 
						FROM contact_aspect inner join aspect ON aspect.id=contact_aspect.aspect_id 
						WHERE aspect.id=:aspect_id AND contact_aspect.user_id=:user_id
					)
				)
				ORDER BY post.create_time DESC", array(
				':user_id'=>Yii::app()->user->getId(),
				':aspect_id'=>$this->aspectId,
			));
		}else{
			$posts = Post::model()->findAllBySql("select * 
				from post 
				where post.user_id=:user_id 
				OR post.id IN (SELECT pa.post_id 
					FROM post_aspect as pa INNER JOIN contact_aspect as ca on ca.aspect_id=pa.aspect_id 
					WHERE ca.contact_id=:user_id 
					AND ca.user_id IN (SELECT contact_id 
						FROM contact 
						WHERE contact.user_id=:user_id
					)
				)
				ORDER BY post.create_time DESC", array(
				':user_id'=>Yii::app()->user->getId(),
			));
		}
		
		$this->render('postStream', array(
			'posts'=>$posts,
		));
	}
}
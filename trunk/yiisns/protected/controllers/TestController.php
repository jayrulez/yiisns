<?php

class TestController extends Controller
{	
	public function actionIndex()
	{
		$contact = Contact::model()->findByAttributes(array(
			'user_id'=>1,
			'person_id'=>2,
		));
		
		if($contact !== null)
		{
			foreach($contact->aspects as $aspect)
			{
				echo $aspect->name."<br/>";
			}
		}//test passed
		
		$aspect = Aspect::model()->findByAttributes(array(
			'id'=>1,
		));
		
		if($aspect !== null)
		{
			foreach($aspect->contacts as $contact)
			{
				echo $aspect->user->username."<br/>";
				echo $contact->person->username."<br/>";
			}
			
			foreach($aspect->posts as $post)
			{
				echo $post->content."<br/>";
			}
		}//test passed
		
		$user = User::model()->findByPk(1);
		
		if($user!== null)
		{
			foreach($user->aspects as $aspect)
			{
				echo $aspect->name."<br/>";
			}
			
			foreach($user->contacts as $contact)
			{
				echo $contact->user->username."<br/>";
				echo $contact->person->username."!<br/>";
			}
			
			foreach($user->requests as $request)
			{
				echo $request->user->username."<br/>";
			}
		}//test passed
		
		$post = Post::model()->findByPk(1);
		if($post !== null)
		{
			foreach($post->aspects as $aspect)
			{
				echo $aspect->name."<br/>";
			}
		}//test passed
	}
}
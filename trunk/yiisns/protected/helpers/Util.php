<?php

class Util
{
	public static function areContacts($user1, $user2)
	{
		return Util::hasContact($user1, $user2) && Util::hasContact($user2, $user1);
	}
	
	public static function hasContact($userId, $contactId)
	{
		$contact = Contact::model()->findByAttributes(array(
			'user_id'=>$userId,
			'contact_id'=>$contactId,
		));
		
		return $model !== null;
	}
	
	public function inAspect($userId, $aspectId)
	{
		$contactAspect = ContactAspect::model()->findByAttributes(array(
			'contact_id'=>$user_id,
			'aspect_id'=>$aspectId,
		));
		
		return $contactAspect !== null;
	}
}
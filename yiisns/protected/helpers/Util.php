<?php

class Util
{
	public static function areContacts($userId, $contactId)
	{
		$contact = Contact::model()->findByAttributes(array(
			'user_id'=>$userId,
			'contact_id'=>$contactId,
		));
		
		return ($contact !== null) && $contact->getIsInversed();
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
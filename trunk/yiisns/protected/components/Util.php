<?php

class Util
{
	public static function areContacts($user1Id, $user2Id)
	{
		$contact1 = Contact::model()->findByAttributes(array(
			'user_id'=>$user1Id,
			'contact_id'=>$user2Id,
		));
		
		$contact2 = Contact::model()->findByAttributes(array(
			'user_id'=>$user1Id,
			'contact_id'=>$user2Id,
		));
		
		if(!($contact1 === null && $contact2 === null))
		{
			return true;
		}
		
		return false;
	}
}
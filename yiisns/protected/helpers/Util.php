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
	
	public static function inAspect($userId, $aspectId)
	{
		$contactAspect = ContactAspect::model()->findByAttributes(array(
			'contact_id'=>$user_id,
			'aspect_id'=>$aspectId,
		));
		
		return $contactAspect !== null;
	}
	
	/*Needs to be refactored*/
	public static function getFuzzyTime($time)
	{
		$timeNow = time();
		
		$diff = $timeNow - $time;
		
		if(abs($diff) < 10)
		{
			return Yii::t('application', 'moments ago');
		}
		
		static $breakPoints = array();
		
		if(!$breakPoints)
		{
			$breakPoints = array(
				/* 45 seconds  */
				45     => array(1,     Yii::t('application', 'second'), Yii::t('application', 'seconds')),
				/* 45 minutes  */
				2700   => array(60,    Yii::t('application', 'minute'), Yii::t('application', 'minutes')),
				/* 18 hours    */
				64800  => array(3600,  Yii::t('application', 'hour'), Yii::t('application', 'hours')),
				/* 5 days      */
				432000 => array(86400, Yii::t('application', 'day'), Yii::t('application', 'days'))
			);
		}
		
		foreach($breakPoints as $breakPoint => $unitInfo)
		{
			if(abs($diff) > $breakPoint)
			{
				continue;
			}
			
			$unitDiff = round(abs($diff)/$unitInfo[0]);
			
			$units = Yii::t('application', Yii::t('application','1#{singular}|n>1#{plural}', array('{singular}'=>$unitInfo[1],'{plural}'=>$unitInfo[2])),array(
				$unitDiff,
			));
			
			break;
		}
		
		return Yii::t('application', '{unitDiff} {units} ago', array(
			'{unitDiff}'=>$unitDiff,
			'{units}'=>$units,
		));
	}
}
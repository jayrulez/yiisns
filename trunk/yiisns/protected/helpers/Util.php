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
	
	public static function getFuzzyTime($time)
	{
		$elapsed = time() - $time;
		
		if($elapsed < 60)
		{
			return Yii::t('application', 'n<1#moments ago|1#{elapsed} second ago|n>1#{elapsed} seconds ago', array(
				$elapsed,
				'{elapsed}'=>round(abs($elapsed)),
			));
		}else{
			$elapsed = round($elapsed / 60);
			if($elapsed < 60)
			{
				return Yii::t('application', 'n<1#less than a minute ago|1#about a minute ago|n>1#{elapsed} minutes ago', array(
					$elapsed,
					'{elapsed}'=>round(abs($elapsed)),
				));
			}else{
				$elapsed = $elapsed / 60;
				if($elapsed < 24)
				{
					return Yii::t('application', '1#about an hour ago|n>1#{elapsed} hours ago', array(
						$elapsed,
						'{elapsed}'=>round(abs($elapsed)),
					));
				}else{
					$elapsed = $elapsed / 24;
					if($elapsed < 7)
					{
						return Yii::t('application', '1#{elapsed} day ago|n>1#{elapsed} days ago', array(
							$elapsed,
							'{elapsed}'=>round(abs($elapsed)),
						));
					}else{
						return Util::formatDateTime($time);
					}
				}
			}
		}
	}
	
	public static function formatDateTime($timestamp)
	{		
		$date = date('Y', time()) > date('Y', $timestamp) ? date('F j, Y', $timestamp) : date('F j', $timestamp);
		$time = date('g:i a', $timestamp);
		
		return Yii::t('application', '{date} at {time}', array(
			'{date}'=>$date,
			'{time}'=>$time,
		));
	}
}
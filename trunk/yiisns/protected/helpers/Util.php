<?php

class Util
{
	public static function shortenString($string, $length, $suspension = '...')
	{
		return strlen($string) > $length ? substr($string, 0, $length).$suspension : $string;
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
}
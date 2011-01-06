<?php

return CMap::mergeArray(require_once(dirname(__FILE__).'/modules.php'), array(
	'gii'=>array(
		'class'=>'system.gii.GiiModule',
		'password'=>'yiisns',
	),
));
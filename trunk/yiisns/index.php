<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/../lib/yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

// development environment
defined('ENV_DEV') or define('ENV_DEV', defined('YII_DEBUG') && YII_DEBUG);

require_once($yii);

Yii::setPathOfAlias('lib', dirname(__FILE__).'/../lib');

require_once(dirname(__FILE__).'/global.php');

$app = Yii::createWebApplication($config);
$app->run();

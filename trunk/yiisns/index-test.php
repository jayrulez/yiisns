<?php
/**
 * This is the bootstrap file for test application.
 * This file should be removed when the application is deployed for production.
 */

// change the following paths if necessary
$yii=dirname(__FILE__).'/../lib/yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/test.php';

// remove the following line when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);

require_once($yii);

Yii::setPathOfAlias('lib', dirname(__FILE__).'/../lib');

require_once(dirname(__FILE__).'/global.php');

Yii::createWebApplication($config)->run();

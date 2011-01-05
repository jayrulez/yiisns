<?php
/**
 * This is the bootstrap file for test application.
 * This file should be removed when the application is deployed for production.
 */
require_once(dirname(__FILE__).'/global.php');
$config=dirname(__FILE__).'/protected/config/test.php';

Yii::createWebApplication($config)->run();

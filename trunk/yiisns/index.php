<?php

require_once(dirname(__FILE__).'/global.php');
$config=dirname(__FILE__).'/protected/config/main.php';

$app = Yii::createWebApplication($config);
$app->run();

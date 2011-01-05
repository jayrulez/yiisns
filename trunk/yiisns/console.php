<?php

require_once(dirname(__FILE__).'/global.php');
$config=dirname(__FILE__).'/protected/config/console.php';

$app = Yii::createConsoleApplication($config);
$app->run();

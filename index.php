<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/../yii-1.1.10.r3566/yii.php';
if($_SERVER['SERVER_NAME']==='cms-test') // Remove in production mode
{
	$config=dirname(__FILE__).'/protected/config/test.php';
}
else
	$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

require_once $yii;
require_once 'protected/components/SWebApplication.php';

// Create application
$app = Yii::createApplication('SWebApplication', $config);
$app->run();

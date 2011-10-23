<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/../yii1.1.8/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

require_once($yii);

// Create application
$app = Yii::createWebApplication($config);

// Enable installed modules
$modules = SystemModules::getEnabled();

if ($modules)
{
	foreach ($modules as $module)
		$app->setModules(array($module->name));
}

$app->run();
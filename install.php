<?php

$config=array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'protected',
	'sourceLanguage'=>'ru',
	'modules'=>array(
		'install',
	),
	'components'=>array(
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>true,
			'rules'=>array(
				'/'=>'install/default',
		)),
	),
);

// change the following paths if necessary
$yii=dirname(__FILE__).'/../yii-1.1.10.r3566/yii.php';
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

require_once $yii;
Yii::createWebApplication($config)->run();

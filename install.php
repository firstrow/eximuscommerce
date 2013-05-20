<?php

$config=array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'protected',
	'sourceLanguage'=>'ru',
	'modules'=>array(
		'install',
	),
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),
	'components'=>array(
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>true,
			'rules'=>array(
				'/'=>'install/default',
		)),
		'languageManager'=>array(
			'class'=>'SLanguageManager'
		),
	),
	'params'=>array(
	),
);

error_reporting(0);
define('VERSION', '{EXIMUS_VERSION}');

// change the following paths if necessary
$yii=dirname(__FILE__).'/framework/yii.php';
//defined('YII_DEBUG') or define('YII_DEBUG', true);
//defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

require_once $yii;
Yii::createWebApplication($config)->run();

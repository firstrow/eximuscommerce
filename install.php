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
		'storeImages'=>array(
			'path'=>'webroot.uploads.product',
			'maxFileSize'=>10*1024*1024,
			'extensions'=>array('jpg', 'jpeg','png', 'gif'),
			'types'=>array('image/gif','image/jpeg', 'image/pjpeg', 'image/png',  'image/x-png'),
			'sizes'=>array(
				'resizeMethod'=>'resize', // resize/adaptiveResize
				'resizeThumbMethod'=>'resize', // resize/adaptiveResize
				'maximum'=>array(800, 600), // All uploaded images
			)
		)
	),
);

error_reporting(0);

// change the following paths if necessary
$yii=dirname(__FILE__).'/framework/yii.php';
//defined('YII_DEBUG') or define('YII_DEBUG', true);
//defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

require_once $yii;
Yii::createWebApplication($config)->run();

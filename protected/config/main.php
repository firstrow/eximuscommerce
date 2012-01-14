<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder')
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Shop',
	'language'=>'ru',
	//'sourceLanguage'=>'ru',
	//'theme'=>'development',
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.components.validators.*',
		'application.modules.core.models.*',
		'application.modules.users.models.User',
		// Rights module
		'application.modules.rights.*',
		'application.modules.rights.components.*',
	),

	'modules'=>array(
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
		   'ipFilters'=>array('127.0.0.*'),
		),
		'admin'=>array(),
		'rights'=>array(
			'layout'=>'application.modules.admin.views.layouts.main',
			'cssFile'=>false,
			'debug'=>YII_DEBUG,
			//'appLayout'=>'application.modules.admin.views.layouts.main,'
		),
		'core',
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'class'=>'RWebUser',
			'allowAutoLogin'=>true,
		),
		'urlManager'=>array(
			'urlFormat'=>'path',
			'class'=>'SUrlManager',
			'showScriptName'=>false,
			'useStrictParsing'=>true,
			'rules'=>array(
				'admin/auth'=>'admin/auth',
				'admin/auth/logout'=>'admin/auth/logout',
				'admin/<module:\w+>'=>'<module>/admin/default',
				'admin/<module:\w+>/<controller:\w+>'=>'<module>/admin/<controller>',
				'admin/<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/admin/<controller>/<action>',
				'admin/<module:\w+>/<controller:\w+>/<action:\w+>/*'=>'<module>/admin/<controller>/<action>',

				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',

				'rights'=>'rights/assignment/view',
				'rights/<controller:\w+>/<id:\d+>'=>'rights/<controller>/view',
				'rights/<controller:\w+>/<action:\w+>/<id:\d+>'=>'rights/<controller>/<action>',
				'rights/<controller:\w+>/<action:\w+>'=>'rights/<controller>/<action>',
			),
		),
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=my_db',
			'enableProfiling' => YII_DEBUG, // Disable in production
			'emulatePrepare' => true,
			//'schemaCachingDuration'=>3600, // Enable in production
			'username' => 'root',
			'password' => 'mysqlpass',
			'charset' => 'utf8',
		),
		'request'=>array(
			'class'=>'SHttpRequest',
			'enableCsrfValidation'=>true,
			'enableCookieValidation'=>true,
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'authManager'=>array(
			//'class'=>'CDbAuthManager',
			'class'=>'RDbAuthManager',
			'connectionID'=>'db',
		),
		'cache'=>array(
			'class'=>'CFileCache',
		),
		'languageManager'=>array(
			'class'=>'SLanguageManager'
		),
		'fixture'=>array(
			'class'=>'system.test.CDbFixtureManager',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
					array(
						'class'=>'CFileLogRoute',
						'levels'=>'error, warning, trace',
					),
					array(
						'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
						'ipFilters'=>array('127.0.0.1'),
					),
			),
		),
	),
	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		//'adminEmail'=>'webmaster@example.com',
		'storeImages'=>array(
			'path'=>'webroot.uploads.product',
			'maxFileSize'=>10*1024*1024,
			'extensions'=>array('jpg', 'jpeg','png', 'gif'),
			'types'=>array('image/gif','image/jpeg', 'image/pjpeg', 'image/png',  'image/x-png'),
			'url'=>'/uploads/product/', // With ending slash
			'sizes'=>array(
				'resizeMethod'=>'resize', // or resizeAdaptive
				'maximum'=>array(800, 600), // All uploaded images
			)
		)
	),
);

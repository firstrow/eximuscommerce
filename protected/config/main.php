<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder')
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'language'=>'ru',
	//'sourceLanguage'=>'ru',
	'theme'=>'default',
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.components.payment.*',
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
		'action_logger',
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
			'allowAutoLogin'=>true,
			'class'=>'BaseUser',
			'loginUrl'=>'/users/login'
		),
		'urlManager'=>array(
			'urlFormat'=>'path',
			'class'=>'SUrlManager',
			'showScriptName'=>false,
			'useStrictParsing'=>true,
			'rules'=>array(
				'/'=>'store/index/index',
				'admin/auth'=>'admin/auth',
				'admin/auth/logout'=>'admin/auth/logout',
				'admin/<module:\w+>'=>'<module>/admin/default',
				'admin/<module:\w+>/<controller:\w+>'=>'<module>/admin/<controller>',
				'admin/<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/admin/<controller>/<action>',
				'admin/<module:\w+>/<controller:\w+>/<action:\w+>/*'=>'<module>/admin/<controller>/<action>',

				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',

				'admin'=>'admin/default/index',
				'rights'=>'rights/assignment/view',
				'rights/<controller:\w+>/<id:\d+>'=>'rights/<controller>/view',
				'rights/<controller:\w+>/<action:\w+>/<id:\d+>'=>'rights/<controller>/<action>',
				'rights/<controller:\w+>/<action:\w+>'=>'rights/<controller>/<action>',

				'gii'=>'gii',
				'gii/<controller:\w+>'=>'gii/<controller>',
				'gii/<controller:\w+>/<action:\w+>'=>'gii/<controller>/<action>',
			),
		),
		'db'=>array(
			'connectionString'      => 'mysql:host=localhost;dbname=my_db',
			'username'              => 'root',
			'password'              => 'mysqlpass',
			'enableProfiling'       => YII_DEBUG, // Disable in production
			'enableParamLogging'    => YII_DEBUG, // Disable in production
			'emulatePrepare'        => true,
			'schemaCachingDuration' => YII_DEBUG ? 0 : 3600,
			'charset'               => 'utf8',
		),
		'request'=>array(
			'class'=>'SHttpRequest',
			'enableCsrfValidation'=>true,
			'enableCookieValidation'=>true,
			'noCsrfValidationRoutes'=>array(
				'orders/payment/process',
				'accounting1c/default',
			)
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
			//'class'=>'CApcCache',
		),
		'languageManager'=>array(
			'class'=>'SLanguageManager'
		),
		'fixture'=>array(
			'class'=>'system.test.CDbFixtureManager',
		),
		'cart'=>array(
			'class'=>'ext.cart.SCart',
		),
		'currency'=>array(
			'class'=>'store.components.SCurrencyManager'
		),
		'mail'=>array(
			'class'=>'ext.mailer.EMailer',
			'CharSet'=>'UTF-8',
		),
		'settings'=>array(
			'class'=>'application.components.SSystemSettings'
		),
		'log'=>YII_DEBUG===true ? require('logging.php') : null,
	),
	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
		'adminPageSize'=>30,
		'storeImages'=>array(
			'path'=>'webroot.uploads.product',
			'thumbPath'=>'webroot.assets.productThumbs',
			'maxFileSize'=>10*1024*1024,
			'extensions'=>array('jpg', 'jpeg','png', 'gif'),
			'types'=>array('image/gif','image/jpeg', 'image/pjpeg', 'image/png',  'image/x-png'),
			'url'=>'/uploads/product/', // With ending slash
			'thumbUrl'=>'/assets/productThumbs/', // With ending slash
			'sizes'=>array(
				'resizeMethod'=>'resize', // resize/adaptiveResize
				'resizeThumbMethod'=>'resize', // resize/adaptiveResize
				'maximum'=>array(800, 600), // All uploaded images
			)
		)
	),
);

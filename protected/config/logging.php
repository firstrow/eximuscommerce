<?php

return array(
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
);
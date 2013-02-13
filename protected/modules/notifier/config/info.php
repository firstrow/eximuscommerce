<?php

Yii::import('application.modules.notifier.NotifierModule');

/**
 * Notifications module info
 */ 
return array(
	'name'        => Yii::t('NotifierModule.core', 'Сообщить о появлении'),
	'author'      => 'firstrow@gmail.com',
	'version'     => '0.2',
	'description' => Yii::t('NotifierModule.core', 'Помогает рассылать сообщения пользователям, когда продукт появился в наличии.'),
	'config_url'  => Yii::app()->createUrl('/notifier/admin/default'),
	'url'         => '',
);

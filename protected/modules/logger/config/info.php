<?php

Yii::import('application.modules.logger.LoggerModule');

/**
 * Module info
 */
return array(
	'name'        => Yii::t('LoggerModule.admin', 'Журнал действий'),
	'author'      => 'firstrow@gmail.com',
	'version'     => '0.1',
	'description' => Yii::t('LoggerModule.admin', 'Запись действий пользователя в панели управления.'),
	'config_url'  => Yii::app()->createUrl('/logger/admin/default'),
	'url'         => '', # Url to module home page.
);
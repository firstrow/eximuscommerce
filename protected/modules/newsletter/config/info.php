<?php

Yii::import('application.modules.newsletter.NewsletterModule');

/**
 * Module info
 */
return array(
	'name'        => Yii::t('NewsletterModule.admin', 'Рассылка писем'),
	'author'      => 'firstrow@gmail.com',
	'version'     => '0.1',
	'description' => Yii::t('NewsletterModule.core', 'Массовая рассылка писем пользователям.'),
	'config_url'  => Yii::app()->createUrl('/newsletter/admin/default'),
	'url'         => '', # Url to module home page.
);
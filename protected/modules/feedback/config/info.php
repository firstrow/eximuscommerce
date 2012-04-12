<?php

Yii::import('application.modules.feedback.FeedbackModule');

/**
 * Module info
 */ 
return array(
	'name'        => Yii::t('FeedbackModule.core', 'Обратная связь'),
	'author'      => 'firstrow@gmail.com',
	'version'     => '0.1',
	'config_url'  => Yii::app()->createUrl('/feedback/admin/default/index'), // Url to change module settings
	'description' => Yii::t('FeedbackModule.core', 'Обеспечивает работу формы обратной связи на вашем сайте.'),
	'url'         => '', # Url to module home page.
);
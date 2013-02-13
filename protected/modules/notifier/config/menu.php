<?php

Yii::import('application.modules.notifier.NotifierModule');

return array(
		'notifier'=>array(
			'label'    => Yii::t('NotifierModule.core', 'Уведомления'),
			'url'      => array('/admin/notifier'),
			'position' => 9,
		),
);
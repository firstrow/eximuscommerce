<?php

Yii::import('application.modules.logger.LoggerModule');

return array(
	'users'=>array(
		'items'=>array(
			array(
				'label'=>Yii::t('LoggerModule.admin', 'Журнал действий'),
				'url'=>Yii::app()->createUrl('/logger/admin/default'),
				'position'=>8
			),
		),
	),
);
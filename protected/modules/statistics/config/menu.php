<?php

Yii::import('application.modules.statistics.StatisticsModule');

return array(
	'statistics'=>array(
		'label'    => Yii::t('StatisticsModule.admin', 'Статистика'),
		'url'      => Yii::app()->createUrl('/statistics/admin/default'),
		'position' => 10,
		'items'=>array(
			array(
				'label'    => Yii::t('StatisticsModule.admin', 'Заказы'),
				'url'      => Yii::app()->createUrl('/statistics/admin/default'),
				'position' => 1
			)
		),
	),
);
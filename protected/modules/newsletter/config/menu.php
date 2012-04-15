<?php

Yii::import('application.modules.newsletter.NewsletterModule');

return array(
	'users'=>array(
		'items'=>array(
			array(
				'label'=>Yii::t('NewsletterModule.admin', 'Рассылка писем'),
				'url'=>Yii::app()->createUrl('/newsletter/admin/default'),
				'position'=>5
			),
		),
	),
);
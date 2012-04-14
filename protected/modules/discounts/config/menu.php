<?php

Yii::import('application.modules.discounts.DiscountsModule');

/**
 * Admin menu items for discounts module
 */
return array(
	'catalog'=>array(
		'items'=>array(
			array(
				'label'=>Yii::t('DiscountsModule.admin', 'Скидки'),
				'url'=>Yii::app()->createUrl('/discounts/admin/default'),
				'position'=>1
			),
		),
	),
);
<?php

Yii::import('orders.OrdersModule');

/**
 * Admin menu items for pages module
 */
return array(
	'orders'=>array(
		'label'=>Yii::t('OrdersModule.admin', 'Заказы'),
		'url'=>array('/orders/admin/orders'),
		'position'=>2,
		'items'=>array(
			array(
				'label'=>Yii::t('OrdersModule.admin', 'Все заказы'),
				'url'=>array('/orders/admin/orders'),
				'position'=>1
			),
			array(
				'label'=>Yii::t('OrdersModule.admin', 'Создать заказ'),
				'url'=>array('/orders/admin/orders/create'),
				'position'=>2
			),
			array(
				'label'=>Yii::t('OrdersModule.admin', 'Статусы'),
				'url'=>array('/orders/admin/statuses'),
				'position'=>3
			)
		),
	),
);
<?php

Yii::import('orders.OrdersModule');

/**
 * Admin menu items for pages module
 */
return array(
	'orders'=>array(
		'label'=>Yii::t('OrdersModule.admin', 'Заказы'),
		'position'=>2,
		'url'=>array('/orders/admin/orders'),
	),
);
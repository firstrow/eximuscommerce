<?php

/**
 * View user orders
 * @var $orders
 */

$this->pageTitle=Yii::t('UsersModule.core', 'Мои заказы');
?>
<h1 class="has_background"><?php echo Yii::t('UsersModule.core', 'Мои заказы'); ?></h1>

<?php
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'           => 'ordersListGrid',
		'dataProvider' => $orders->search(),
		'template'     => '{items}',
		'columns' => array(
			array(
				'name'=>'user_name',
				'type'=>'raw',
				'value'=>'CHtml::link(CHtml::encode($data->user_name), array("/orders/cart/view", "secret_key"=>$data->secret_key))',
			),
			'user_email',
			'user_phone',
			array(
				'name'=>'status_id',
				'filter'=>CHtml::listData(OrderStatus::model()->orderByPosition()->findAll(), 'id', 'name'),
				'value'=>'$data->status_name'
			),
			array(
				'name'=>'delivery_id',
				'filter'=>CHtml::listData(StoreDeliveryMethod::model()->orderByPosition()->findAll(), 'id', 'name'),
				'value'=>'$data->delivery_name'
			),
			array(
				'type'=>'raw',
				'name'=>'full_price',
				'value'=>'StoreProduct::formatPrice($data->full_price)',
			),
		),
	));
?>
<?php

$this->pageHeader = Yii::t('OrdersModule.admin', 'Последние заказы');

$this->breadcrumbs = array(
	'Home'=>$this->createUrl('/admin'),
	Yii::t('OrdersModule.admin', 'Главная'),
);

// Side bar
$this->sidebarContent = $this->renderPartial('_sidebar', array(
	'ordersTotalPrice'=>$this->getOrdersTotalPrice()
), true);

// Orders list
$this->widget('ext.sgridview.SGridView', array(
	'dataProvider'=>$ordersDataProvider,
	'id'=>'ordersListGrid',
	'selectableRows'=>0,
	'template'=>'{items}',
	'columns'=>array(
		array(
			'class'=>'SGridIdColumn',
			'name'=>'id'
		),
		array(
			'name'=>'user_name',
			'type'=>'raw',
			'value'=>'CHtml::link(CHtml::encode($data->user_name), array("/orders/admin/orders/update", "id"=>$data->id))',
		),
		'user_email',
		'user_phone',
		array(
			'name'=>'status_id',
			'value'=>'$data->status_name'
		),
		array(
			'name'=>'delivery_id',
			'value'=>'$data->delivery_name'
		),
		array(
			'class'=>'SProductsPreviewColumn'
		),
		array(
			'type'=>'raw',
			'name'=>'full_price',
			'value'=>'StoreProduct::formatPrice($data->full_price)',
		),
		'created',
	),
));

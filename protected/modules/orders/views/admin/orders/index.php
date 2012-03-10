<?php

/**
 * Display orders list
 **/

$this->pageHeader = Yii::t('OrdersModule.admin', 'Заказы');

$this->breadcrumbs = array(
	'Home'=>$this->createUrl('/admin'),
	Yii::t('OrdersModule.admin', 'Заказы'),
);

$this->topButtons = $this->widget('admin.widgets.SAdminTopButtons', array(
	'template'=>array('create'),
	'elements'=>array(
		'create'=>array(
			'link'=>$this->createUrl('create'),
			'title'=>Yii::t('OrdersModule.admin', 'Создать заказ'),
			'options'=>array(
				'icons'=>array('primary'=>'ui-icon-cart')
			)
		),
	),
));

$this->widget('ext.sgridview.SGridView', array(
	'dataProvider'=>$dataProvider,
	'id'=>'ordersListGrid',
	'filter'=>$model,
	'columns'=>array(
		array(
			'class'=>'CCheckBoxColumn',
		),
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
		'status_id',
		'created',
		// Buttons
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update}{delete}',
		),
	),
));
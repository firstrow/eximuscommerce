<?php

/**
 * Display statuseslist
 **/

$this->pageHeader = Yii::t('OrdersModule.admin', 'Статусы заказов');

$this->breadcrumbs = array(
	'Home'=>$this->createUrl('/admin'),
	Yii::t('OrdersModule.admin', 'Статусы заказов'),
);

$this->topButtons = $this->widget('admin.widgets.SAdminTopButtons', array(
	'template'=>array('create'),
	'elements'=>array(
		'create'=>array(
			'link'=>$this->createUrl('create'),
			'title'=>Yii::t('OrdersModule.admin', 'Новый статус'),
			'options'=>array(
				'icons'=>array('primary'=>'ui-icon-plus')
			)
		),
	),
));

$this->widget('ext.sgridview.SGridView', array(
	'dataProvider'=>$dataProvider,
	'id'=>'orderStatusesListGrid',
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
			'name'=>'name',
			'type'=>'raw',
			'value'=>'CHtml::link(CHtml::encode($data->name), array("/orders/admin/statuses/update", "id"=>$data->id))',
		),
		'position',
		// Buttons
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update}{delete}',
		),
	),
));
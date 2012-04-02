<?php

/**
 * Display delivery methods list
 **/

$this->pageHeader = Yii::t('StoreModule.admin', 'Способы доставки');

$this->breadcrumbs = array(
	'Home'=>$this->createUrl('/admin'),
	Yii::t('StoreModule.admin', 'Способы доставки'),
);

$this->topButtons = $this->widget('admin.widgets.SAdminTopButtons', array(
	'template'=>array('create'),
	'elements'=>array(
		'create'=>array(
			'link'=>$this->createUrl('create'),
			'title'=>Yii::t('StoreModule.admin', 'Создать способ доставки'),
			'options'=>array(
				'icons'=>array('primary'=>'ui-icon-plus')
			)
		),
	),
));

$this->widget('ext.sgridview.SGridView', array(
	'dataProvider'=>$dataProvider,
	'id'=>'deliveryMethodsListGrid',
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
			'value'=>'CHtml::link(CHtml::encode($data->name), array("/store/admin/delivery/update", "id"=>$data->id))',
		),
		'price',
		'free_from',
		'position',
		array(
			'name'=>'active',
			'filter'=>array(1=>Yii::t('StoreModule.admin', 'Да'), 0=>Yii::t('StoreModule.admin', 'Нет')),
			'value'=>'$data->active ? Yii::t("StoreModule.admin", "Да") : Yii::t("StoreModule.admin", "Нет")'
		),
		// Buttons
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update}{delete}',
		),
	),
));
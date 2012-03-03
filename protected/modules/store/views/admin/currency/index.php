<?php

/**
 * Display currency list
 **/

$this->pageHeader = Yii::t('StoreModule.admin', 'Валюты');

$this->breadcrumbs = array(
	'Home'=>$this->createUrl('/admin'),
	Yii::t('StoreModule.admin', 'Валюты'),
);

$this->topButtons = $this->widget('admin.widgets.SAdminTopButtons', array(
	'template'=>array('create'),
	'elements'=>array(
		'create'=>array(
			'link'=>$this->createUrl('create'),
			'title'=>Yii::t('StoreModule.admin', 'Создать валюту'),
			'options'=>array(
				'icons'=>array('primary'=>'ui-icon-plus')
			)
		),
	),
));

$this->widget('ext.sgridview.SGridView', array(
	'dataProvider'=>$dataProvider,
	'id'=>'productsListGrid',
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
			'value'=>'CHtml::link(CHtml::encode($data->name), array("/store/admin/currency/update", "id"=>$data->id))',
		),
		'rate',
		'symbol',
		array(
			'name'=>'main',
			'filter'=>array(1=>Yii::t('StoreModule.admin', 'Да'), 0=>Yii::t('StoreModule.admin', 'Нет')),
			'value'=>'$data->main ? Yii::t("StoreModule.admin", "Да") : Yii::t("StoreModule.admin", "Нет")'
		),
		array(
			'name'=>'default',
			'filter'=>array(1=>Yii::t('StoreModule.admin', 'Да'), 0=>Yii::t('StoreModule.admin', 'Нет')),
			'value'=>'$data->default ? Yii::t("StoreModule.admin", "Да") : Yii::t("StoreModule.admin", "Нет")'
		),
		// Buttons
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update}{delete}',
		),
	),
));
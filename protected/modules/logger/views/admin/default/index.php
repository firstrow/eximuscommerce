<?php

/**
 * Display logs
 **/

$this->pageHeader = Yii::t('LoggerModule.admin', 'Журнал действий');

$this->sidebarContent = $this->renderPartial('_sidebar', array(), true);

$this->breadcrumbs = array(
	'Home'=>$this->createUrl('/admin'),
	Yii::t('LoggerModule.admin', 'Модули')=>Yii::app()->createUrl('/core/admin/systemModules'),
	Yii::t('LoggerModule.admin', 'Журнал действий'),
);

$this->widget('ext.sgridview.SGridView', array(
	'dataProvider'=>$dataProvider,
	'id'=>'loggerListGrid',
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
			'name'=>'username',
		),
		array(
			'name'=>'event',
			'type'=>'raw',
			'value'=>'$data->actionTitle',
		),
		array(
			'name'=>'model_name',
		),
		array(
			'name'=>'model_title',
		),
		'datetime',
		// Buttons
		array(
			'class'=>'CButtonColumn',
			'template'=>'{delete}',
		),
	),
));

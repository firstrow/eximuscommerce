<?php

/**
 * Display logs
 **/

$this->pageHeader = Yii::t('LoggerModule.admin', 'Журнал действий');

$this->breadcrumbs = array(
	'Home'=>$this->createUrl('/admin'),
	Yii::t('LoggerModule.admin', 'Модули')=>Yii::app()->createUrl('/core/admin/systemModules'),
	Yii::t('LoggerModule.admin', 'Журнал действий'),
);

$this->widget('ext.sgridview.SGridView', array(
	'dataProvider'=>$dataProvider,
	'id'=>'loggerListGrid',
	'afterAjaxUpdate'=>"function(){registerFilterDatePickers()}",
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
			'type'=>'raw',
			'value'=>'$data->getHumanModelName()',
			'filter'=>$model->getModelNameFilter()
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

Yii::app()->clientScript->registerScript("pageDatepickers", "
	function registerFilterDatePickers(id, data){
		jQuery('input[name=\"ActionLog[datetime]\"]').datepicker({
			dateFormat:'yy-mm-dd',
			constrainInput: false
		});
	}
	registerFilterDatePickers();
");

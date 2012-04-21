<?php

	/** Display pages list **/
	$this->pageHeader = Yii::t('PagesModule.core', 'Страницы');

	$this->breadcrumbs = array(
		'Home'=>$this->createUrl('/admin'),
		Yii::t('PagesModule.core', 'Страницы'),
	);

	$this->topButtons = $this->widget('application.modules.admin.widgets.SAdminTopButtons', array(
		'template'=>array('create'),
		'elements'=>array(
			'create'=>array(
				'link'=>$this->createUrl('create'),
				'title'=>Yii::t('PagesModule.core', 'Создать страницу'),
				'options'=>array(
					'icons'=>array('primary'=>'ui-icon-plus')
				)
			),
		),
	));

	$this->widget('ext.sgridview.SGridView', array(
		'dataProvider'=>$dataProvider,
		'id'=>'pagesListGrid',
		'afterAjaxUpdate'=>"function(){registerFilterDatePickers()}",
		'filter'=>$model,
		'columns'=>array(
			array(
				'class'=>'CCheckBoxColumn',
			),
			array(
				'class'=>'SGridIdColumn',
				'name'=>'id',
			),
			array(
				'name'=>'title',
				'type'=>'raw',
				'value'=>'CHtml::link(CHtml::encode($data->title), array("update", "id"=>$data->id))',
			),
			array(
				'name'=>'url',
				'type'=>'raw',
				'value'=>'CHtml::link(CHtml::encode($data->url), $data->getViewUrl(), array("target"=>"_blank"))',
			),
			array(
				'name'=>'category_id',
				'type'=>'raw',
				'value'=>strtr('$data->category ? $data->category->getUpdateLink(): "{no}"', array(
					'{no}'=>Yii::t('PagesModule.core', 'Нет')
				)),
				'filter'=>PageCategory::keyValueList()
			),
			array(
				'name'=>'user_id',
				'type'=>'raw',
				'value'=>'$data->author->getUpdateLink()',
			),
			array(
				'name'=>'status',
				'value'=>'CHtml::encode($data->statusLabel)',
				'filter'=>Page::statuses()
			),
			'publish_date',
			// Buttons
			array(
				'class'=>'CButtonColumn',
				'template'=>'{update}{delete}',
			),
		),
	));

	Yii::app()->clientScript->registerScript("pageDatepickers", "
		function registerFilterDatePickers(id, data){
			jQuery('input[name=\"Page[publish_date]\"]').datepicker({
				dateFormat:'yy-mm-dd',
				constrainInput: false
			});
		}
		registerFilterDatePickers();
	");
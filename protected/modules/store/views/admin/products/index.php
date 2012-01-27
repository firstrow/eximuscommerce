<?php

	/**
	 * Display products list
	 **/

	$this->pageHeader = Yii::t('StoreModule.admin', 'Продукты');

	$this->sidebarContent = $this->renderPartial('_sidebar', array(), true);

	// Register scripts
	Yii::app()->clientScript->registerScriptFile(
		$this->module->assetsUrl.'/admin/products.index.js',
		CClientScript::POS_END
	);

	$this->breadcrumbs = array(
		'Home'=>$this->createUrl('/admin'),
		Yii::t('StoreModule.admin', 'Продукты'),
	);

	$this->topButtons = $this->widget('application.modules.admin.widgets.SAdminTopButtons', array(
		'template'=>array('create'),
		'elements'=>array(
			'create'=>array(
				'link'=>$this->createUrl('create'),
				'title'=>Yii::t('StoreModule.admin', 'Создать продукт'),
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
				'value'=>'CHtml::link(CHtml::encode($data->name), array("/store/admin/products/update", "id"=>$data->id))',
			),
			array(
				'name'=>'url',
				'type'=>'raw',
				'value'=>'CHtml::link(CHtml::encode($data->url), array("/store/frontProduct/view", "url"=>$data->url), array("target"=>"_blank"))',
			),
			'sku',
			'price',
			array(
				'name'=>'type_id',
				'type'=>'raw',
				'value'=>'$data->type->name',
				'filter'=>CHtml::listData(StoreProductType::model()->findAll(), "id", "name"),
			),
			array(
				'name'=>'is_active',
				'filter'=>array(1=>Yii::t('StoreModule.admin', 'Да'), 0=>Yii::t('StoreModule.admin', 'Нет')),
				'value'=>'$data->is_active ? Yii::t("StoreModule.admin", "Да") : Yii::t("StoreModule.admin", "Нет")'
			),
			// Buttons
			array(
				'class'=>'CButtonColumn',
				'template'=>'{update}{delete}',
			),
		),
	));
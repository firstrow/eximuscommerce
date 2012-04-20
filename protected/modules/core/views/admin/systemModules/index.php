<?php

	/** Display installed modules list **/

	$this->pageHeader = Yii::t('CoreModule.core', 'Модули');

	$this->breadcrumbs = array(
		'Home'=>$this->createUrl('/admin'),
		Yii::t('CoreModule.core', 'Модули'),
	);

	$this->topButtons = $this->widget('application.modules.admin.widgets.SAdminTopButtons', array(
		'template'=>array('new'),
		'elements'=>array(
			'new'=>array(
				'link'=>$this->createUrl('install'),
				'title'=>Yii::t('CoreModule.core', 'Установить'),
				'icon'=>'plus',
			),
		),
	));

	$this->widget('ext.sgridview.SGridView', array(
		'dataProvider'=>$dataProvider,
		'id'=>'modulesListGrid',
		'filter'=>$model,
		'extended'=>false,
		'columns'=>array(
			array(
				'name'=>'name',
				'type'=>'raw',
				'value'=>'($data->getInfo()->config_url) ? CHtml::link(CHtml::encode($data->getInfo()->name), $data->getInfo()->config_url) : CHtml::encode($data->getInfo()->name)',
				'filter'=>false,
			),
			array(
				'name'=>'description',
				'value'=>'CHtml::encode($data->getInfo()->description)',
				'header'=>Yii::t('CoreModule.core', 'Описание'),
				'filter'=>false,
			),
			array(
				'header'=>Yii::t('CoreModule.core', 'Версия'),
				'type'=>'raw',
				'value'=>'$data->getInfo()->version'
			),
//			array(
//				'name'=>'enabled',
//				'value'=>strtr('$data->enabled ? "{yes}":"{no}"', array(
//					'{yes}'=>Yii::t('CoreModule.core', 'Да'),
//					'{no}'=>Yii::t('CoreModule.core', 'Нет')
//				)),
//				'filter'=>array(1=>Yii::t('CoreModule.core', 'Да'),0=>Yii::t('CoreModule.core', 'Нет')),
//			),
			// Buttons
			array(
				'class'=>'CButtonColumn',
				'template'=>'{delete}',
			),
		),
	));
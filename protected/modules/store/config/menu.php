<?php

Yii::import('application.modules.store.StoreModule');

/**
 * Admin menu items for store module
 */
return array(
	'catalog'=>array(
		'items'=>array(
			array(
				'label'=>Yii::t('StoreModule.admin', 'Продукты'),
				'url'=>Yii::app()->createUrl('store/admin/products'),
				'position'=>1
			),
			array(
				'label'=>Yii::t('StoreModule.admin', 'Категории'),
				'url'=>Yii::app()->createUrl('store/admin/category/create'),
				'position'=>2
			),
			array(
				'label'=>Yii::t('StoreModule.admin', 'Производители'),
				'url'=>Yii::app()->createUrl('store/admin/manufacturer'),
				'position'=>3
			),
		),
	),
);
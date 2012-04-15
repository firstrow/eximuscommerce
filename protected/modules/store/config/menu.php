<?php

Yii::import('application.modules.store.StoreModule');

/**
 * Admin menu items for store module
 */
return array(
	'catalog'=>array(
		'position'=>3,
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
			array(
				'label'=>Yii::t('StoreModule.admin', 'Атрибуты'),
				'url'=>Yii::app()->createUrl('store/admin/attribute'),
				'position'=>4
			),
			array(
				'label'=>Yii::t('StoreModule.admin', 'Типы продуктов'),
				'url'=>Yii::app()->createUrl('store/admin/productType'),
				'position'=>5
			),
			array(
				'label'=>Yii::t('StoreModule.admin', 'Доставка'),
				'url'=>Yii::app()->createUrl('store/admin/delivery'),
				'position'=>6
			),
			array(
				'label'=>Yii::t('StoreModule.admin', 'Оплата'),
				'url'=>Yii::app()->createUrl('store/admin/paymentMethod'),
				'position'=>7
			),
			array(
				'label'=>Yii::t('StoreModule.admin', 'Валюты'),
				'url'=>Yii::app()->createUrl('store/admin/currency'),
				'position'=>8
			),
		),
	),
);
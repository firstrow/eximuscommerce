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
                'url'=>Yii::app()->createUrl('store/admin/category'),
                'position'=>2
            ),
        ),
    ),
);
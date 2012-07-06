<?php

// Import module to make translation available.
Yii::import('application.modules.core.CoreModule');

/**
 * Admin menu items for core module
 */
return array(
	'users'=>array(
		'items'=>array(
			array(
				'label'=>Yii::t('CoreModule.core', 'Настройки'),
				'url'=>Yii::app()->createUrl('core/admin/systemSettings'),
				'position'=>0
			),
			array(
				'label'=>Yii::t('CoreModule.core', 'Модули'),
				'url'=>Yii::app()->createUrl('core/admin/systemModules'),
				'position'=>3
			),
			array(
				'label'=>Yii::t('CoreModule.core', 'Языки'),
				'url'=>Yii::app()->createUrl('core/admin/systemLanguages'),
				'position'=>4
			),
		),
	),
);
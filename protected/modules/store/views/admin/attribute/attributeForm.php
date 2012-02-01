<?php

return array(
	'id'=>'attributeUpdateForm',
	'showErrorSummary'=>true,
	'elements'=>array(
		'content'=>array(
			'type'=>'form',
			'title'=>Yii::t('StoreModule.admin', 'Параметры'),
			'elements'=>array(
				'title'=>array(
					'type'=>'text',
				),
				'name'=>array(
					'type'=>'text',
					'hint'=>Yii::t('StoreModule.admin', 'Укажите уникальный идентификатор')
				),
				'type'=>array(
					'type'=>'dropdownlist',
					'items'=>StoreAttribute::getTypesList()
				),
				'use_in_filter'=>array(
					'type'=>'dropdownlist',
					'items'=>array(
						1=>Yii::t('StoreModule.admin', 'Да'),
						0=>Yii::t('StoreModule.admin', 'Нет')
					),
					'hint'=>Yii::t('StoreModule.admin', 'TODO: Add hit text')
				),
				'position'=>array(
					'type'=>'text',
				),
			),
		),
	),
);


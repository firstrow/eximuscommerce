<?php

return array(
	'id'=>'productUpdateForm',
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
				'position'=>array(
					'type'=>'text',
				),
			),
		),
	),
);


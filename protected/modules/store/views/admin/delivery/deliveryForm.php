<?php

/**
 * Delivery method sform
 */
return array(
	'id'=>'deliveryUpdateForm',
	'elements'=>array(
		'tab1'=>array(
			'type'=>'form',
			'title'=>'',
			'elements'=>array(
				'name'=>array(
					'type'=>'text',
				),
				'active'=>array(
					'type'=>'dropdownlist',
					'items'=>array(
						1=>Yii::t('StoreModule.admin', 'Да'),
						0=>Yii::t('StoreModule.admin', 'Нет')
					),
				),
				'price'=>array(
					'type'=>'text',
				),
				'free_from'=>array(
					'type'=>'text',
				),
				'description'=>array(
					'type'=>'SRichTextarea',
				),
				'position'=>array(
					'type'=>'text',
					'hint'=>Yii::t('StoreModule.admin', 'Оставьте пустым для установки максимального значения')
				),
				'payment_methods'=>array(
					'type'=>'checkboxlist',
					'items'=>CHtml::listData(StorePaymentMethod::model()->findAll(), 'id', 'name'),
				),
			),
		),
	),
);

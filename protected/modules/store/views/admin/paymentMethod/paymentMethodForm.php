<?php

/**
 * Delivery method form
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
				'description'=>array(
					'type'=>'SRichTextarea',
				),
				'currency_id'=>array(
					'type'=>'dropdownlist',
					'items'=>CHtml::listData(StoreCurrency::model()->findAll(),'id','name'),
				),
				'payment_system'=>array(
					'type'=>'dropdownlist',
					'empty'=>'---',
					'items'=>$this->model->getPaymentSystemsArray(),
					'rel'=>$this->model->id,
				),
				'<div id="payment_configuration"></div>',
				'position'=>array(
					'type'=>'text',
					'hint'=>Yii::t('StoreModule.admin', 'Оставьте пустым для установки максимального значения')
				),
			),
		),
	),
);

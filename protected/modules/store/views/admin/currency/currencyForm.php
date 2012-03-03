<?php

/**
 * Currency form
 */
return array(
	'id'=>'currencyUpdateForm',
	'elements'=>array(
		'tab1'=>array(
			'type'=>'form',
			'title'=>'',
			'elements'=>array(
				'name'=>array(
					'type'=>'text',
				),
				'main'=>array(
					'type'=>'dropdownlist',
					'items'=>array(
						0=>Yii::t('StoreModule.admin', 'Нет'),
						1=>Yii::t('StoreModule.admin', 'Да')
					),
				),
				'default'=>array(
					'type'=>'dropdownlist',
					'items'=>array(
						0=>Yii::t('StoreModule.admin', 'Нет'),
						1=>Yii::t('StoreModule.admin', 'Да')
					),
				),
				'iso'=>array(
					'type'=>'text',
				),
				'symbol'=>array(
					'type'=>'text',
				),
				'rate'=>array(
					'type'=>'text',
				),
			),
		),
	),
);

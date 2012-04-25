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
					'hint'=>Yii::t('StoreModule.admin', 'Все цены на сайте указаны в этой валюте.')
				),
				'default'=>array(
					'type'=>'dropdownlist',
					'items'=>array(
						0=>Yii::t('StoreModule.admin', 'Нет'),
						1=>Yii::t('StoreModule.admin', 'Да')
					),
					'hint'=>Yii::t('StoreModule.admin', 'Валюта будет назначена пользователю при первом посещении сайта.')
				),
				'iso'=>array(
					'type'=>'text',
				),
				'symbol'=>array(
					'type'=>'text',
				),
				'rate'=>array(
					'type'=>'text',
					'hint'=>Yii::t('StoreModule.admin', 'Курс по отношению к главной валюте сайта.')
				),
			),
		),
	),
);

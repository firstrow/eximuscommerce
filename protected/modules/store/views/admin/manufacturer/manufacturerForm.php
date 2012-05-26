<?php

return array(
	'id'=>'manufacturerUpdateForm',
	'elements'=>array(
		'content'=>array(
			'type'=>'form',
			'title'=>Yii::t('StoreModule.admin', 'Общая информация'),
			'elements'=>array(
				'name'=>array(
					'type'=>'text',
				),
				'url'=>array(
					'type'=>'text',
				),
				'description'=>array(
					'type'=>'SRichTextarea',
				),
			),
		),
		'seo'=>array(
			'type'=>'form',
			'title'=>Yii::t('StoreModule.admin', 'Мета данные'),
			'elements'=>array(
				'meta_title'=>array(
					'type'=>'text',
				),
				'meta_keywords'=>array(
					'type'=>'textarea',
				),
				'meta_description'=>array(
					'type'=>'textarea',
				),
			),
		),
		'design'=>array(
			'type'=>'form',
			'title'=>Yii::t('StoreModule.admin', 'Дизайн'),
			'elements'=>array(
				'layout'=>array(
					'type'=>'text',
				),
				'view'=>array(
					'type'=>'text',
				),
			),
		),
	),
);


<?php

/*** Create/update page form ***/

return array(
	'id'=>'pageUpdateForm',
	'showErrorSummary'=>true,
	'elements'=>array(
		'content'=>array(
			'type'=>'form',
			'title'=>Yii::t('PagesModule.core', 'Параметры'),
			'elements'=>array(
				'name'=>array(
					'type'=>'text',
				),
				'url'=>array(
					'type'=>'text',
				),
				'parent_id'=>array(
					'type'=>'dropdownlist',
					'items'=>PageCategory::keyValueList(),
					'empty'=>'---',
					'options'=>array(
						$this->model->id=>array('disabled'=>true),
					)
				),
				'description'=>array(
					'type'=>'SRichTextarea',
				),
			),
		),
		'seo'=>array(
			'type'=>'form',
			'title'=>Yii::t('PagesModule.core', 'Мета данные'),
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
			'title'=>Yii::t('PagesModule.core', 'Внешний вид'),
			'elements'=>array(
				'page_size'=>array(
					'type'=>'text',
				),
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


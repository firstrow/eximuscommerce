<?php

/**
 * Comment form
 */
Yii::import('zii.widgets.jui.CJuiDatePicker');

return array(
	'id'=>'commentUpdateForm',
	'elements'=>array(
		'tab1'=>array(
			'type'=>'form',
			'title'=>'',
			'elements'=>array(
				'status'=>array(
					'type'=>'dropdownlist',
					'items'=>Comment::getStatuses()
				),
				'name'=>array(
					'type'=>'text',
				),
				'email'=>array(
					'type'=>'text'
				),
				'text'=>array(
					'type'=>'textarea',
					'style'=>'height:200px'
				),
				'created'=>array(
					'type'=>'CJuiDatePicker',
					'options'=>array(
						'dateFormat'=>'yy-mm-dd '.date('H:i:s'),
					),
				),
				'updated'=>array(
					'type'=>'CJuiDatePicker',
					'options'=>array(
						'dateFormat'=>'yy-mm-dd '.date('H:i:s'),
					),
				),
			),
		),
	),
);

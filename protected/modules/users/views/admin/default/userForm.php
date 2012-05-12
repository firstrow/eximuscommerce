<?php

/**
 * User create/update form data 
 */
Yii::import('zii.widgets.jui.CJuiDatePicker');

return array(
	'id'=>'userUpdateForm',
	//'showErrorSummary'=>true,
	'elements'=>array(
		'user'=>array(
			'type'=>'form',
			'title'=>'',
			'elements'=>array(
				'username'=>array(
					'type'=>'text',
				),
				'email'=>array('type'=>'text',),
				'created_at'=>array(
					'type'=>'CJuiDatePicker',
					'options'=>array(
						'dateFormat'=>'yy-mm-dd '.date('H:i:s'),
					),
				),
				'last_login'=>array(
					'type'=>'CJuiDatePicker',
					'options'=>array(
						'dateFormat'=>'yy-mm-dd '.date('H:i:s'),
					),
				),
				'login_ip'=>array('type'=>'text',),
				'new_password'=>array(
					'type'=>'password',
				),
			),
		),
		'profile'=>array(
			'type'=>'form',
			'title'=>'Данные профиля',
			'elements'=>array(
				'full_name'=>array(
					'type'=>'text',
				),
				'phone'=>array(
					'type'=>'text',
				),
				'delivery_address'=>array(
					'type'=>'textarea',
				),
			),
		),
	),
);

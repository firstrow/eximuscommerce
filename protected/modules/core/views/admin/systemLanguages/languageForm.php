<?php

/**
 * Create/update language form 
 */

return array(
	'id'=>'languageUpdateForm',
	'elements'=>array(
		'name'=>array(
            'type'=>'text',
        ),
		'code'=>array(
            'type'=>'text',
            'hint'=>Yii::t('CoreModule.core', 'Например: en'),
        ),
		'locale'=>array(
            'type'=>'text',
            'hint'=>Yii::t('CoreModule.core', 'Например: en, en_us'),
        ),
		'default'=>array(
            'type'=>'checkbox',
        ),
	),
);


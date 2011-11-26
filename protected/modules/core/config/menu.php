<?php

// Import module to make translation aviable.
Yii::import('application.modules.core.CoreModule');

/**
 * Admin menu items for core module
 */
return array(
    'users'=>array(
        'items'=>array(
            array(
                'label'=>Yii::t('CoreModule.core', 'Модули'), 
                'url'=>array('/admin/core/systemModules'), 
                'position'=>3
            ),
        ),
    ),
);
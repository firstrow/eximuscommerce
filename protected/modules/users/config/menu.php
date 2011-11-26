<?php

Yii::import('application.modules.users.UsersModule');

/**
 * Admin menu for users module.
 */
return array(
    'users'=>array(
        'items'=>array(
            array(
                'label'=>Yii::t('UsersModule.core', 'Пользователи'), 
                'url'=>array('/admin/users'), 
                'position'=>3
            ),
        ),
    ),
);
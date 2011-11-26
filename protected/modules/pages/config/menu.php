<?php

Yii::import('application.modules.pages.PagesModule');

/**
 * Admin menu items for pages module
 */
return array(
    'cms'=>array(
        'items'=>array(
            array(
                'label'=>Yii::t('PagesModule.core', 'Страницы'), 
                'url'=>array('/admin/pages'), 
                'position'=>3
            ),
            array(
                'label'=>Yii::t('PagesModule.core', 'Категории'), 
                'url'=>array('/admin/pages/category'), 
                'position'=>4
            ),
        ),
    ),
);
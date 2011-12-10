<?php

return array(
    'id'=>'pageUpdateForm',
    'showErrorSummary'=>true,
    'elements'=>array(
        'content'=>array(
            'type'=>'form',
            'title'=>Yii::t('StoreModule.core', 'Общая информация'),
            'elements'=>array(
                'name'=>array(
                    'type'=>'text',
                ),
                'price'=>array(
                    'type'=>'text',
                ),
                'url'=>array(
                    'type'=>'text',
                ),
                'short_description'=>array(
                    'type'=>'textarea',
                ),
                'full_description'=>array(
                    'type'=>'textarea',
                ),
            ),
        ),
        'seo'=>array(
            'type'=>'form',
            'title'=>Yii::t('StoreModule.core', 'Мета данные'),
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
    ),
);


<?php

return array(
    'id'=>'pageUpdateForm',
    'showErrorSummary'=>true,
    'elements'=>array(
        'content'=>array(
            'type'=>'form',
            'title'=>Yii::t('StoreModule.admin', 'Общая информация'),
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
        'warehouse'=>array(
            'type'=>'form',
            'title'=>Yii::t('StoreModule.admin', 'Склад'),
            'elements'=>array(
                'is_active'=>array(
                    'type'=>'dropdownlist',
                    'items'=>array(
                        1=>Yii::t('StoreModule.admin', 'Да'),
                        0=>Yii::t('StoreModule.admin', 'Нет')
                    ),
                    'hint'=>Yii::t('StoreModule.admin', 'Отображать товар на сайте')
                ),
                'sku'=>array(
                    'type'=>'text',
                ),
                'quantity'=>array(
                    'type'=>'text',
                ),
                'auto_decrease_quantity'=>array(
                    'type'=>'dropdownlist',
                    'items'=>array(
                        1=>Yii::t('StoreModule.admin', 'Да'),
                        0=>Yii::t('StoreModule.admin', 'Нет')
                    ),
                    'hint'=>Yii::t('StoreModule.admin', 'Автоматически уменьшать количество при создании заказа'),
                ),
                'availability'=>array(
                    'type'=>'dropdownlist',
                    'items'=>StoreProduct::getAvailabilityItems()
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


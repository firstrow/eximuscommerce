<?php

// Set parent_id as root on create new category
try{
    if ($this->model->parent)
        $parent_id = $this->model->parent->id;
    else
        $parent_id = 1;
} catch(Exception $e) {
    $parent_id = 1;
}

return array(
    'id'=>'productCategoryUpdateForm',
    'showErrorSummary'=>true,
    'elements'=>array(
        'content'=>array(
            'type'=>'form',
            'title'=>Yii::t('StoreModule.admin', 'Общая информация'),
            'elements'=>array(
                'name'=>array(
                    'type'=>'text',
                ),
                'parent_id'=>array(
                    'type'=>'dropdownlist',
                    'items'=>CHtml::listData(StoreCategory::model()->findAll(array('order'=>'lft')), 'id', 'nameWithLevel'),
                    'options'=>array(
                        $parent_id=>array('selected'=>'selected'),
                        //$this->model->id=>array('disabled'=>'disabled'),
                    ),
                ),
            ),
        ),
//        'seo'=>array(
//            'type'=>'form',
//            'title'=>Yii::t('StoreModule.admin', 'Мета данные'),
//            'elements'=>array(
//                'meta_title'=>array(
//                    'type'=>'text',
//                ),
//                'meta_keywords'=>array(
//                    'type'=>'textarea',
//                ),
//                'meta_description'=>array(
//                    'type'=>'textarea',
//                ),
//            ),
//        ),
//        'design'=>array(
//            'type'=>'form',
//            'title'=>Yii::t('StoreModule.admin', 'Дизайн'),
//            'elements'=>array(
//                'layout'=>array(
//                    'type'=>'text',
//                ),
//                'view'=>array(
//                    'type'=>'text',
//                ),
//            ),
//        ),
    ),
);


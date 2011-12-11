
<table style="width: 70%" id="relatedProductsTable">
</table>

<div>&nbsp;</div>

<?php

/**
 * Related products tab
 */

Yii::app()->clientScript->registerScript("rti18n",
    strtr("var deleteButtonText='{text}';", array(
        '{text}'=>Yii::t('StoreModule.admin','Удалить'),
    )),
CClientScript::POS_HEAD);

Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl.'/admin/relatedProductsTab.js');

if(!isset($model))
{
    $model = new StoreProduct('search');
    $model->exclude = $exclude;
}

$this->widget('ext.sgridview.SGridView', array(
    'dataProvider'=>$model->search(),
    'ajaxUrl'=>Yii::app()->createUrl('store/admin/products/applyProductsFilter/exclude/'.$exclude),
    'id'=>'RelatedProductsGrid',
    'template'=>'{items}{summary}{pager}',
    'enableCustomActions'=>false,
    'extended'=>false,
    'filter'=>$model,
    'columns'=>array(
        array(
            'name'=>'id',
            'type'=>'raw',
            'value'=>'$data->id',
            'filter'=>CHtml::textField('RelatedProducts[id]', $model->id)
        ),
        array(
            'name'=>'name',
            'type'=>'html',
            'value'=>'CHtml::link($data->name, array("update", "id"=>$data->id))',
            'filter'=>CHtml::textField('RelatedProducts[name]', $model->name)
        ),
        array(
            'name'=>'sku',
            'type'=>'raw',
            'value'=>'$data->sku',
            'filter'=>CHtml::textField('RelatedProducts[sku]', $model->sku)
        ),
        array(
            'name'=>'price',
            'type'=>'raw',
            'value'=>'$data->price',
            'filter'=>CHtml::textField('RelatedProducts[price]', $model->price)
        ),
        array(
            'class'=>'CLinkColumn',
            'header'=>'',
            'label'=>Yii::t('StoreModule.admin','Добавить'),
            'urlExpression'=>'$data->id."/".$data->name',
            'htmlOptions'=>array(
                'onClick'=>'return AddRelatedProduct(this);'
            ),
        ),
    ),
));

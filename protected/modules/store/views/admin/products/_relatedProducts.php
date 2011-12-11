<?php

if(!isset($model))
    $model = new StoreProduct();

// ext.sgridview.SGridView
// zii.widgets.grid.CGridView

$this->widget('ext.sgridview.SGridView', array(
    'dataProvider'=>$model->search(),
    'ajaxUrl'=>Yii::app()->createUrl('store/admin/products/applyProductsFilter'),
    'id'=>'productsListGridInner',
    'template'=>'{items}{summary}{pager}',
    'extended'=>false,
    'filter'=>$model,
    'columns'=>array(
        'id',
        array(
            'name'=>'name',
            'type'=>'raw',
            'value'=>'CHtml::link($data->name, array("update", "id"=>$data->id))',
        ),
        array(
            'name'=>'url',
            'type'=>'raw',
            'value'=>'CHtml::link($data->url, $data->url, array("target"=>"_blank"))',
        ),
        'sku',
        'price',
    ),
));

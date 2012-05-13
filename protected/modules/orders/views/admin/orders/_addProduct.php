<div style="padding-bottom:15px;">
<?php

/**
 * Add new product to order.
 * Display products list.
 */

if(!isset($dataProvider))
	$dataProvider = new StoreProduct('search');

// Fix sort url
$dataProvider = $dataProvider->search();
$dataProvider->sort->route = 'addProductList';
$dataProvider->pagination->route = 'addProductList';

$this->widget('zii.widgets.grid.CGridView', array(
	'id'             => 'OrderAddProductsGrid',
	'filter'         => $dataProvider->model,
	'dataProvider'   => $dataProvider,
	'ajaxUrl'        => Yii::app()->createUrl('/orders/admin/orders/addProductList', array('order_id'=>$model->id)),
	'template'       => '{items}{pager}',
	'selectableRows' => 0,
	'columns'=>array(
		array(
			'name'=>'id',
			'type'=>'text',
			'value'=>'$data->id',
		),
		array(
			'name'=>'name',
			'type'=>'raw',
		),
		array(
			'name'=>'sku',
			'value'=>'$data->sku',
		),
		array(
			'type'=>'raw',
			'name'=>'price',
			'value'=>'CHtml::textField("price_{$data->id}", $data->price, array("style"=>"width:80px;border:1px solid silver;padding:1px;"))',
		),
		array(
			'type'=>'raw',
			'value'=>'CHtml::textField("count_{$data->id}", 1, array("style"=>"width:24px;border:1px solid silver;padding:1px;"))',
			'header'=>Yii::t('OrdersModule.admin','Количество'),
		),
		array(
			'class'=>'CLinkColumn',
			'header'=>'',
			'label'=>Yii::t('OrdersModule.admin','Добавить'),
			'urlExpression'=>'$data->id',
			'htmlOptions'=>array(
				'onClick'=>'return addProductToOrder(this, '.$model->id.', "'.Yii::app()->request->csrfToken.'");'
			),
		),
	),
));
?>
</div>
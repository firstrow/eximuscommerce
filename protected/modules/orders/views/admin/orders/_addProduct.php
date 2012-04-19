<div style="padding-bottom:15px;">
	<?php

/**
 * Add new product to order.
 * Display products list.
 */

if(!isset($dataProvider))
	$dataProvider = new StoreProduct('search');

// Fix sort url
Yii::app()->clientScript->registerScript('fixGridSorter', '
	$("#OrderAddProductsGrid .items thead tr th a").each(function(){
		var search    = "/admin/orders/orders/update";
		var replace   = "/admin/orders/orders/addProductList";
		var url       = $(this).attr("href").replace(search, replace)+"&order_id='.$model->id.'";
		$(this).attr("href", url);
	});
', CClientScript::POS_END);

$this->widget('zii.widgets.grid.CGridView', array(
	'id'             => 'OrderAddProductsGrid',
	'dataProvider'   => $dataProvider->search(),
	'ajaxUrl'        => Yii::app()->createUrl('/orders/admin/orders/addProductList', array('order_id'=>$model->id)),
	'template'       => '{items}{pager}',
	'selectableRows' => 0,
	'filter'         => $dataProvider,
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
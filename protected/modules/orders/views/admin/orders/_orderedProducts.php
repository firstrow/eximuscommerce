<?php

$products = new OrderProduct;
$products->order_id = $model->id;
$dataProvider = $products->search();

$this->widget('zii.widgets.grid.CGridView', array(
	'id'               => 'orderedProducts',
	'enableSorting'    => false,
	'enablePagination' => false,
	'dataProvider'     =>  $dataProvider,
	'template'         => '{items}',
	'columns'          => array(
		array(
			'name'=>'renderFullName',
			'type'=>'raw',
			'header'=>Yii::t('OrdersModule.admin', 'Название')
		),
		'quantity',
		'sku',
		array(
			'name'=>'price',
			'value'=>'StoreProduct::formatPrice($data->price)'
		),
		array(
			'type'=>'raw',
			'value'=>'CHtml::link("&times", "#", array("style"=>"font-weight:bold;"))',
		),
	),
));
?>

<div class="row">
	<b><?php echo Yii::t('OrdersModule.admin','Итог') ?>:</b>
	<span><?php echo StoreProduct::formatPrice($model->total_price) .' '.Yii::app()->currency->main->symbol; ?></span>
</div>
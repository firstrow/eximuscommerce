<?php

/**
 * List of order products
 *
 * @var $model Order
 * @var $this OrdersController
 */

$products = new OrderProduct;
$products->order_id = $model->id;
$dataProvider = $products->search();

Yii::app()->clientScript->registerScript('qustioni18n', '
	var deleteQuestion = "'.Yii::t('OrdersModule.admin', 'Вы действительно удалить запись?').'";
	var productSuccessAddedToOrder = "'.Yii::t('OrdersModule.admin', 'Продукт успешно добавлен к заказу.').'";
', CClientScript::POS_BEGIN);

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
			'value'=>'CHtml::link("&times", "#", array("style"=>"font-weight:bold;", "onclick"=>"deleteOrderedProduct($data->id, $data->order_id, \"'.Yii::app()->request->csrfToken.'\")"))',
		),
	),
));
?>

<div class="row">
	<b><?php echo Yii::t('OrdersModule.admin','Итог') ?>:</b>
	<span><?php echo StoreProduct::formatPrice($model->total_price) .' '.Yii::app()->currency->main->symbol; ?></span>
</div>
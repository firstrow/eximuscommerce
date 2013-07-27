<?php

/**
 * Update order
 *
 * @var $model Order
 * @var $this OrdersController
 */


$title = ($model->isNewRecord) ? Yii::t('OrdersModule.admin', 'Создание заказа') :
	Yii::t('OrdersModule.admin', 'Редактирование заказа');
$this->pageHeader = $title;

Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl.'/admin/orders.update.js', CClientScript::POS_END);

$template = array('history_back','save','dropDown');
if($model->isNewRecord===false)
	$template[]='delete';

$this->topButtons = $this->widget('admin.widgets.SAdminTopButtons', array(
	'formId'       => 'orderUpdateForm',
	'template'     => $template,
	'deleteAction' => $this->createUrl('/orders/admin/orders/delete', array('id'=>$model->id)),
	'updateAction' => 'update'
));

$this->breadcrumbs = array(
	'Home'=>$this->createUrl('/admin'),
	Yii::t('OrdersModule.admin', 'Заказы')=>$this->createUrl('index'),
	($model->isNewRecord) ? Yii::t('OrdersModule.admin', 'Создание заказа') :'# '.CHtml::encode($model->id),
);

$this->widget('admin.widgets.schosen.SChosen', array(
	'elements'=>array('Order_delivery_id', 'Order_status_id')
));

// register all delivery methods to recalculate prices
Yii::app()->clientScript->registerScript('deliveryMetohds', strtr('
	var deliveryMethods = {data};
', array(
	'{data}'=>CJavaScript::jsonEncode($deliveryMethods)
)), CClientScript::POS_END);

// Render tabs
$tabs = array(
	Yii::t('OrdersModule.admin', 'Заказ') => $this->renderPartial('_order_tab', array(
		'model'           => $model,
		'statuses'        => $statuses,
		'deliveryMethods' => $deliveryMethods,
	), true),
);

if(!$model->isNewRecord)
{
	// Add history tab
	$tabs[Yii::t('OrdersModule.admin', 'История')] = array(
		'ajax'=>$this->createUrl('history', array('id'=>$model->id))
	);
}

$this->widget('zii.widgets.jui.CJuiTabs',array(
	'tabs'=>$tabs
));
<?php

/**
 * Update order
 *
 * @var $model Order
 * @var $this OrdersController
 */

Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl.'/admin/orders.update.js', CClientScript::POS_END);

$this->topButtons = $this->widget('admin.widgets.SAdminTopButtons', array(
	'formId'=>'orderUpdateForm',
	'deleteAction'=>$this->createUrl('/orders/admin/orders/delete', array('id'=>$model->id))
));

$title = ($model->isNewRecord) ? Yii::t('OrdersModule.admin', 'Создание заказа') :
	Yii::t('OrdersModule.admin', 'Редактирование заказа');

$this->breadcrumbs = array(
	'Home'=>$this->createUrl('/admin'),
	Yii::t('OrdersModule.admin', 'Заказы')=>$this->createUrl('index'),
	($model->isNewRecord) ? Yii::t('OrdersModule.admin', 'Создание заказа') :'# '.CHtml::encode($model->id),
);

$this->pageHeader = $title;

$this->widget('admin.widgets.schosen.SChosen', array(
	'elements'=>array('Order_delivery_id')
));

?>

<style type="text/css">
	div.userData input[type=text] {
		width: 400px;
	}
	div.userData textarea {
		width: 403px;
	}
	#orderedProducts {
		padding: 0 0 5px 0;
	}
	.ui-dialog .ui-dialog-content {
		padding: 0;
	}
	#dialog-modal .grid-view {
		padding: 0;
	}
</style>

<div class="form wide padding-all">
	<?php
		echo CHtml::form($this->createUrl('update', array('id'=>$model->id)), 'post', array('id'=>'orderUpdateForm'));

		if($model->hasErrors())
		{
			echo CHtml::errorSummary($model);
		}
	?>
		<table width="100%">
			<tr valign="top">
				<td width="50%">
					<!-- User data -->
					<div class="userData">
						<h4><?php echo Yii::t('OrdersModule.admin', 'Данные пользователя'); ?></h4>
						<div class="row">
							<?php echo CHtml::activeLabel($model,'delivery_id', array('required'=>true)); ?>
							<?php echo CHtml::activeDropDownList($model, 'delivery_id', CHtml::listData($deliveryMethods, 'id', 'name')); ?>
						</div>

						<div class="row">
							<?php echo CHtml::activeLabel($model,'paid'); ?>
							<?php echo CHtml::activeCheckBox($model, 'paid'); ?>
						</div>

						<div class="row">
							<?php echo CHtml::activeLabel($model,'user_name', array('required'=>true)); ?>
							<?php echo CHtml::activeTextField($model,'user_name'); ?>
						</div>

						<div class="row">
							<?php echo CHtml::activeLabel($model,'user_email', array('required'=>true)); ?>
							<?php echo CHtml::activeTextField($model,'user_email'); ?>
						</div>

						<div class="row">
							<?php echo CHtml::activeLabel($model,'user_phone'); ?>
							<?php echo CHtml::activeTextField($model,'user_phone'); ?>
						</div>

						<div class="row">
							<?php echo CHtml::activeLabel($model,'user_address'); ?>
							<?php echo CHtml::activeTextField($model,'user_address'); ?>
						</div>

						<div class="row">
							<?php echo CHtml::activeLabel($model,'user_comment'); ?>
							<?php echo CHtml::activeTextArea($model,'user_comment'); ?>
						</div>
					</div>
				</td>
				<td>
					<!-- Right block -->
					<h4><?php echo Yii::t('OrdersModule.admin','Продукты') ?></h4>
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

					<div align="right">
						<a href="javascript:openAddProductDialog(<?php echo $model->id ?>);"><?php echo Yii::t('OrdersModule.admin','Добавить продукт') ?></a>
					</div>

					<div id="dialog-modal" style="display: none;">
						<?php
							$this->renderPartial('_addProduct', array(
								'model'=>$model,
							));
						?>
					</div>

					<div class="row">
						<b><?php echo Yii::t('OrdersModule.admin','Итог') ?>:</b>
						<span><?php echo StoreProduct::formatPrice($model->total_price) .' '.Yii::app()->currency->main->symbol; ?></span>
					</div>
				</td>
			</tr>
		</table>
	<?php echo CHtml::endForm(); ?>
</div>
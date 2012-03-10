<?php

/**
 * Update order
 *
 * @var $model Order
 * @var $this OrdersController
 */

$this->topButtons = $this->widget('admin.widgets.SAdminTopButtons', array(
	//'form'=>$form,
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
						<h4>Данные пользователя</h4>
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
					<h4>Продукты</h4>
					<?php
						$products = new OrderProduct;
						$products->order_id = $model->id;
						$dataProvider = $products->search();

						$this->widget('zii.widgets.grid.CGridView', array(
							'id'=>'orderedProducts',
							'enableSorting'=>false,
							'enablePagination'=>false,
							'dataProvider'=>$dataProvider,
							'template'=>'{items}',
							'columns'=>array(
								'name',
								'quantity',
								'sku',
								array(
									'name'=>'price',
									'value'=>'StoreProduct::formatPrice($data->price * $data->quantity)'
								),
								array(
									'type'=>'raw',
									'value'=>'CHtml::link("&times", "#", array("style"=>"font-weight:bold;"))',
								),
							),
						));
					?>

					<div class="row">
						<label><b>Итог:</b></label>
						<?php echo StoreProduct::formatPrice($model->total_price) .' '.Yii::app()->currency->main->symbol; ?>
					</div>
				</td>
			</tr>
		</table>
	<?php echo CHtml::endForm(); ?>
</div>
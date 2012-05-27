<?php

/**
 * View order
 * @var Order $model
 */

$title = Yii::t('OrdersModule.core', 'Просмотр заказа #{id}', array('{id}'=>$model->id));
$this->pageTitle = $title;

?>

<h1 class="has_background"><?php echo $title; ?></h1>

<div class="order_products">
	<table width="100%">
		<thead>
		<tr>
			<td></td>
			<td>Количество</td>
			<td>Сумма</td>
		</tr>
		</thead>
		<tbody>
		<?php foreach($model->getOrderedProducts()->getData() as $product): ?>
		<tr>
			<td>
				<?php echo CHtml::openTag('h3') ?>
				<?php echo $product->getRenderFullName(false); ?>
				<?php echo CHtml::closeTag('h3') ?>

				<?php echo CHtml::openTag('span', array('class'=>'price')) ?>
				<?php echo StoreProduct::formatPrice(Yii::app()->currency->convert($product->price)) ?>
				<?php echo Yii::app()->currency->active->symbol; ?>
				<?php echo CHtml::closeTag('span') ?>
			</td>
			<td>
				<?php echo $product->quantity ?>
			</td>
			<td>
				<?php echo StoreProduct::formatPrice(Yii::app()->currency->convert($product->price * $product->quantity)); ?>
				<?php echo Yii::app()->currency->active->symbol; ?>
			</td>
		</tr>
		<?php endforeach ?>
		</tbody>
	</table>

	<div class="order_data mt10">
		<div class="user_data rc5">
			<h2><?php echo Yii::t('OrdersModule.core', 'Данные получателя') ?></h2>

			<div class="form wide">
				<div class="row">
					<?php echo Yii::t('OrdersModule.core', 'Доставка') ?>:
					<?php echo CHtml::encode($model->delivery_name); ?>
				</div>
				<div class="row">
					<?php echo Yii::t('OrdersModule.core', 'Стоимость') ?>:
					<?php echo StoreProduct::formatPrice(Yii::app()->currency->convert($model->delivery_price)) ?>
					<?php echo Yii::app()->currency->active->symbol ?>
				</div>
				<div class="row">
					<?php echo CHtml::encode($model->user_name); ?>
				</div>
				<div class="row">
					<?php echo CHtml::encode($model->user_email); ?>
				</div>
				<div class="row">
					<?php echo CHtml::encode($model->user_phone); ?>
				</div>
				<div class="row">
					<?php echo CHtml::encode($model->user_address); ?>
				</div>
				<div class="row">
					<?php echo CHtml::encode($model->user_comment); ?>
				</div>
			</div>
		</div>
	</div>


	<?php foreach($model->deliveryMethod->paymentMethods as $payment): ?>
	<div class="order_data mt10 ">
		<div class="user_data rc5 activeHover">
			<h3><?php echo $payment->name ?></h3>
			<p><?php echo $payment->description ?></p>
			<p><?php echo $payment->renderPaymentForm($model) ?></p>
		</div>
	</div>
	<?php endforeach ?>


	<div class="recount">
		<span class="total">Всего к оплате:</span>
		<span id="total">
			<?php echo StoreProduct::formatPrice(Yii::app()->currency->convert($model->full_price)) ?>
			<?php echo Yii::app()->currency->active->symbol ?>
		</span>
	</div>

	<div style="clear: both;"></div>

</div>

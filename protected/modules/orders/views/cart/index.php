<?php

/**
 * Display cart
 * @var Controller $this
 * @var SCart $cart
 * @var $totalPrice integer
 */

Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl.'/cart.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScript('cartScript', "var orderTotalPrice = '$totalPrice';", CClientScript::POS_HEAD);

$this->pageTitle = Yii::t('OrdersModule.core', 'Оформление заказа');

if(empty($items))
{
	echo CHtml::openTag('h2');
	echo Yii::t('OrdersModule.core', 'Корзина пуста');
	echo CHtml::closeTag('h2');
	return;
}
?>

<h1 class="has_background"><?php echo Yii::t('OrdersModule.core', 'Оформление заказа') ?></h1>

<?php echo CHtml::form() ?>
<div class="order_products">
	<table width="100%">
		<thead>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td>Количество</td>
			<td>Сумма</td>
		</tr>
		</thead>
		<tbody>
		<?php foreach($items as $index=>$product): ?>
		<tr>
			<td style="vertical-align:middle;" width="20px">
				<?php echo CHtml::link('&nbsp;', array('/orders/cart/remove', 'index'=>$index), array('class'=>'remove')) ?>
			</td>
			<td width="110px" align="center">
				<?php
					// Display image
					if($product['model']->mainImage)
						$imgSource = $product['model']->mainImage->getUrl('100x100');
					else
						$imgSource = 'http://placehold.it/100x100';
					echo CHtml::image($imgSource, '', array('class'=>'thumbnail'));
				?>
			</td>
			<td>
				<?php
					$price = StoreProduct::calculatePrices($product['model'], $product['variant_models'], $product['configurable_id']);

					// Display product name with its variants and configurations
					echo CHtml::link(CHtml::encode($product['model']->name), array('/store/frontProduct/view', 'url'=>$product['model']->url)).'<br/>';

					// Price
					echo CHtml::openTag('span', array('class'=>'price'));
					echo StoreProduct::formatPrice(Yii::app()->currency->convert($price));
					echo ' '.Yii::app()->currency->active->symbol;
					echo CHtml::closeTag('span');

					// Display variant options
					if(!empty($product['variant_models']))
					{
						echo CHtml::openTag('span', array('class'=>'cartProductOptions'));
						foreach($product['variant_models'] as $variant)
							echo ' - '.$variant->attribute->title.': '.$variant->option->value.'<br/>';
						echo CHtml::closeTag('span');
					}

					// Display configurable options
					if(isset($product['configurable_model']))
					{
						$attributeModels = StoreAttribute::model()->findAllByPk($product['model']->configurable_attributes);
						echo CHtml::openTag('span', array('class'=>'cartProductOptions'));
						foreach($attributeModels as $attribute)
						{
-							$method = 'eav_'.$attribute->name;
							echo ' - '.$attribute->title.': '.$product['configurable_model']->$method.'<br/>';
						}
						echo CHtml::closeTag('span');
					}
				?>
			</td>
			<td>
				<button class="small_silver_button plus">+</button>
				<?php echo CHtml::textField("quantities[$index]", $product['quantity'], array('class'=>'count')) ?>
				<button class="small_silver_button minus">&minus;</button>
			</td>
			<td>
				<?php
				echo CHtml::openTag('span', array('class'=>'price'));
				echo StoreProduct::formatPrice(Yii::app()->currency->convert($price * $product['quantity']));
				echo ' '.Yii::app()->currency->active->symbol;
				echo CHtml::closeTag('span');
				?>
			</td>
		</tr>
		<?php endforeach ?>
		</tbody>
	</table>

	<div class="recount">
		<div class="silver_clean silver_button">
			<button class="recount" name="recount" type="submit" value="1">Пересчитать</button>
		</div>
		<span class="total">Всего:</span>
		<span id="total">
			<?php echo StoreProduct::formatPrice($totalPrice) ?>
			<?php echo Yii::app()->currency->active->symbol ?>
		</span>
	</div>

</div>

<div class="order_data">
	<div class="left">
		<div class="delivery rc5">
			<h2>Способ доставки</h2>
			<ul>
				<?php foreach($deliveryMethods as $delivery): ?>
				<li>
					<label class="radio">
						<?php
						echo CHtml::activeRadioButton($this->form, 'delivery_id', array(
							'checked'        => ($this->form->delivery_id == $delivery->id),
							'uncheckValue'   => null,
							'value'          => $delivery->id,
							'data-price'     => Yii::app()->currency->convert($delivery->price),
							'data-free-from' => Yii::app()->currency->convert($delivery->free_from),
							'onClick'        => 'recountOrderTotalPrice(this);',
						));
						?>
						<span><?php echo CHtml::encode($delivery->name) ?></span>
					</label>
					<p><?=$delivery->description?></p>
				</li>
				<?php endforeach; ?>
		</div>
	</div>

	<div class="user_data rc5">
		<h2>Адрес получателя</h2>

		<div class="form wide">
			<?php echo CHtml::errorSummary($this->form); ?>

			<div class="row">
				<?php echo CHtml::activeLabel($this->form,'name', array('required'=>true)); ?>
				<?php echo CHtml::activeTextField($this->form,'name'); ?>
			</div>

			<div class="row">
				<?php echo CHtml::activeLabel($this->form,'email', array('required'=>true)); ?>
				<?php echo CHtml::activeTextField($this->form,'email'); ?>
			</div>

			<div class="row">
				<?php echo CHtml::activeLabel($this->form,'phone'); ?>
				<?php echo CHtml::activeTextField($this->form,'phone'); ?>
			</div>

			<div class="row">
				<?php echo CHtml::activeLabel($this->form,'address'); ?>
				<?php echo CHtml::activeTextField($this->form,'address'); ?>
			</div>

			<div class="row">
				<?php echo CHtml::activeLabel($this->form,'comment'); ?>
				<?php echo CHtml::activeTextArea($this->form,'comment'); ?>
			</div>
		</div>
	</div>

</div>

<div style="clear:both;"></div>

<div class="has_background confirm_order">
	<h1>Всего к оплате:</h1>
	<span id="orderTotalPrice" class="total"><?php echo StoreProduct::formatPrice($totalPrice) ?></span>
	<span class="current_currency">
		<?php echo Yii::app()->currency->active->symbol; ?>
	</span>
	<button class="blue_button" type="submit" name="create" value="1">Оформить</button>
</div>

<?php echo CHtml::endForm() ?>
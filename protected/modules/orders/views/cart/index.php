<h3>Корзина</h3>
<?php
	$this->pageTitle = 'Корзина';

	$cart = Yii::app()->cart;
	$items = $cart->getDataWithModels();

	if(empty($items))
	{
		echo CHtml::openTag('h4');
		echo 'Корзина пуста.';
		echo CHtml::closeTag('h4');
		return;
	}

?>

<script type="text/javascript">
	var orderTotalPrice = '<?php echo Yii::app()->cart->getTotalPrice() ?>';

	/**
	 * Recount total price on change delivery method
	 * @param el
	 */
	function recountOrderTotalPrice(el)
	{
		var total          = parseFloat(orderTotalPrice);
		var delivery_price = parseFloat($(el).attr('data-price'));
		var free_from      = parseFloat($(el).attr('data-free-from'));

		if(delivery_price > 0)
		{
			if(free_from > 0 && total > free_from)
			{
				// free delivery
			}else{
				total = total + delivery_price;
			}
		}

		$('#orderTotalPrice').html( total.toFixed(2) );
	}
</script>

<?php echo CHtml::form() ?>
	<table width="100%" class="table table-bordered table-striped">
		<thead>
		<tr>
			<th>Фото</th>
			<th>Название продукта</th>
			<th>Количество</th>
			<th>Сумма</th>
			<th width="10px"></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($items as $index=>$product): ?>
		<tr>
			<td width="110px">
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
					// Display product name with its variants and configurations
					echo CHtml::link(CHtml::encode($product['model']->name), array('/store/frontProduct/view', 'url'=>$product['model']->url)).'<br/>';

					// Display variant options
					if(!empty($product['variant_models']))
					{
						echo CHtml::openTag('span', array('class'=>'cartProductOptions'));
						foreach($product['variant_models'] as $variant)
							echo ' - '.$variant->attribute->title.': '.$variant->option->value.'<br/>';
						echo CHtml::closeTag('span');
					}

					// Display congigurable options
					if(isset($product['configurable_model']))
					{
						$attributeModels = StoreAttribute::model()->findAllByPk($product['model']->configurable_attributes);
						echo CHtml::openTag('span', array('class'=>'cartProductOptions'));
						foreach($attributeModels as $attribute)
						{
							$method = 'eav_'.$attribute->name;
							echo ' - '.$attribute->title.': '.$product['configurable_model']->$method.'<br/>';
						}
						echo CHtml::closeTag('span');
					}
				?>
			</td>
			<td><?php echo CHtml::textField("quantities[$index]", $product['quantity'], array('class'=>'span1')) ?></td>
			<td>
				<?php
					$price = StoreProduct::calculatePrices($product['model'], $product['variant_models'], $product['configurable_id']);
					echo StoreProduct::formatPrice(Yii::app()->currency->convert($price * $product['quantity']));
					echo ' '.Yii::app()->currency->active->symbol;
				?>
			</td>
			<td>
				<?php echo CHtml::link('&times;', array('/orders/cart/remove', 'index'=>$index), array('class'=>'close')) ?>
			</td>
		</tr>
		<?php endforeach ?>
		</tbody>
	</table>

	<div align="right" style="padding: 5px;">
		Итог: <span id="orderTotalPrice">
				<?php echo StoreProduct::formatPrice(Yii::app()->currency->convert(Yii::app()->cart->getTotalPrice())) ?>
			</span> <?php echo Yii::app()->currency->active->symbol ?>
	</div>

	<div align="right">
		<input type="submit" value="Пересчитать" name="recount" class="btn btn-small">
	</div>

	<div>
		<h3>Способ доставки</h3>
		<?php
		foreach($deliveryMethods as $delivery)
		{
			?>
			<label class="radio">
				<?php
					echo CHtml::activeRadioButton($this->form, 'delivery_id', array(
						'checked'        => ($this->form->delivery_id == $delivery->id),
						'uncheckValue'   => null,
						'value'          => $delivery->id,
						'data-price'     => $delivery->price,
						'data-free-from' => $delivery->free_from,
						'onClick'        => 'recountOrderTotalPrice(this);',
					));
				?>
				<h4><?=CHtml::encode($delivery->name)?></h4>
				<p><?=CHtml::encode($delivery->description)?></p>
			</label>
			<?php
		}
		?>
	</div>

	<div>
		<h3>Данные пользователя</h3>
		<div>
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
		</div><!-- form -->
	</div>

	<div align="right" class="form-actions">
		<input type="submit" value="Оформить заказ" name="create" class="btn btn-primary">
	</div>

<?php echo CHtml::endForm() ?>
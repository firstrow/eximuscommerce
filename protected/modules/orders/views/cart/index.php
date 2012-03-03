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

	<div align="right" class="form-actions">
		<input type="submit" value="Пересчитать" name="recount" class="btn btn-small">
	</div>
<?php echo CHtml::endForm() ?>
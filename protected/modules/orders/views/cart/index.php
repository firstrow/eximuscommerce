<h3>Cart</h3>
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


<table width="100%" class="cartTable">
	<thead>
	<tr>
		<th>Фото</th>
		<th>Название продукта</th>
		<th>Количество</th>
		<th>Сумма</th>
		<th></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach($items as $index=>$product): ?>
	<tr valign="top">
		<td width="110px">
			<?php
				// Display image
				if($product['model']->mainImage)
					$imgSource = $product['model']->mainImage->getUrl('100x100');
				else
					$imgSource = 'http://placehold.it/100x100';
				echo CHtml::link(CHtml::image($imgSource), array('frontProduct/view', 'url'=>$product['model']->url), array('class'=>'thumbnail'));
			?>
		</td>
		<td>
			<?php
				// Display product name with its variants and configurations
				echo CHtml::encode($product['model']->name).'<br/>';

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
		<td><?php echo CHtml::textField($index, $product['quantity'], array('class'=>'span1')) ?></td>
		<td>
			sum
		</td>
		<td>
			<?php echo CHtml::link('Удалить', array('/orders/cart/remove', 'index'=>$index)) ?>
		</td>
	</tr>
	<?php endforeach ?>
	</tbody>
</table>
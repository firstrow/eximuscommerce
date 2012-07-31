<?php

/**
 * Display related product
 * @var StoreProduct $model
 */
?>
<div class="products_list">
	<?php foreach($model->relatedProducts as $data):  ?>
		<div class="product_block">
			<div class="image">
				<?php
				if($data->mainImage)
					$imgSource = $data->mainImage->getUrl('190x150');
				else
					$imgSource = 'http://placehold.it/190x150';
				echo CHtml::link(CHtml::image($imgSource), array('frontProduct/view', 'url'=>$data->url));
				?>
			</div>
			<div class="name">
				<?php echo CHtml::link(CHtml::encode($data->name), array('frontProduct/view', 'url'=>$data->url)) ?>
			</div>
			<div class="price">
				<?php
				if($data->appliedDiscount)
					echo '<span style="color:red; "><s>'.$data->toCurrentCurrency('originalPrice').'</s></span>';
				?>
				<?php echo $data->priceRange() ?>
			</div>
			<div class="actions">
				<?php
				echo CHtml::form(array('/orders/cart/add'));
				echo CHtml::hiddenField('product_id', $data->id);
				echo CHtml::hiddenField('product_price', $data->price);
				echo CHtml::hiddenField('use_configurations', $data->use_configurations);
				echo CHtml::hiddenField('currency_rate', Yii::app()->currency->active->rate);
				echo CHtml::hiddenField('configurable_id', 0);
				echo CHtml::hiddenField('quantity', 1);

				echo CHtml::ajaxSubmitButton(Yii::t('StoreModule.core','Купить'), array('/orders/cart/add'), array(
					'id'=>'addProduct'.$data->id,
					'dataType'=>'json',
					'success'=>'js:function(data, textStatus, jqXHR){processCartResponseFromList(data, textStatus, jqXHR, "'.Yii::app()->createAbsoluteUrl('/store/frontProduct/view', array('url'=>$data->url)).'")}',
				), array('class'=>'blue_button'));
				?>
				<button class="small_silver_button" title="<?=Yii::t('core','Сравнить')?>" onclick="return addProductToCompare(<?php echo $data->id ?>);"><span class="compare">&nbsp</span></button>
				<button class="small_silver_button" title="<?=Yii::t('core','В список желаний')?>" onclick="return addProductToWishList(<?php echo $data->id ?>);"><span class="heart">&nbsp;</span></button>
				<?php echo Chtml::endForm() ?>
			</div>
		</div>
	<?php endforeach; ?>
</div>


<div style="clear: both;"></div>
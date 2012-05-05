<?php

/**
 * Small cart.
 * This template is loaded thru ajax request after new product added to cart.
 */
?>
<div class="cart_left"></div>
<div class="cart_right">
	<a href="<?php echo Yii::app()->createUrl('/orders/cart/index') ?>" class="light">
		В корзине <?php echo Yii::app()->cart->countItems() ?> товаров
		на <?php echo StoreProduct::formatPrice(Yii::app()->currency->convert(Yii::app()->cart->getTotalPrice())) ?>
		<?php echo Yii::app()->currency->active->symbol ?>
	</a>
</div>
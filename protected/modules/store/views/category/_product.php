<?php
/**
 * @var StoreProduct $data
 */
?>

<!--<!-- Left column  -->-->
<!--<div class="span2">-->
<!--	--><?php
//		if($data->mainImage)
//			$imgSource = $data->mainImage->getUrl('170x124');
//		else
//			$imgSource = 'http://placehold.it/170x124';
//
//		echo CHtml::link(CHtml::image($imgSource), array('frontProduct/view', 'url'=>$data->url), array('class'=>'thumbnail'));
//	?>
<!--</div>-->
<!---->
<!--<!-- Right column -->-->
<!--<div class="span5">-->
<!--	--><?php //echo CHtml::link(CHtml::encode($data->name), array('frontProduct/view', 'url'=>$data->url)) ?>
<!--	<br>-->
<!--	--><?php
//		if($data->appliedDiscount)
//		{
//			echo '<span style="color:red; "><s>'.$data->originalPrice.'</s></span>';
//		}
//	?>
<!---->
<!--	--><?php //echo $data->priceRange() ?>
<!--</div>-->
<!---->
<!--<div style="clear:both;height: 10px;"></div>-->

<div class="product_block">
	<div class="image">
		<img align="middle" src="http://i5.rozetka.ua/goods/6351/lenovo_ideapad_s205_59_310726_black_6351765.jpg">
	</div>
	<div class="name">
		<a href="">Sony VAIO Black VHFHF456 DFGDF FF G H</a>
	</div>
	<div class="price">
		799.99 $
	</div>
	<div class="actions">
		<form action="#">
			<button class="blue_button" type="submit">Купить</button>

			<button class="small_silver_button"><span class="compare">&nbsp</span></button>
			<button class="small_silver_button"><span class="heart">&nbsp;</span></button>
		</form>
	</div>
</div>
<?php
/**
 * @var StoreProduct $data
 */
?>
<!-- Left column  -->
<div class="span2">
	<?php
		if($data->mainImage)
			$imgSource = $data->mainImage->getUrl('170x124');
		else
			$imgSource = 'http://placehold.it/170x124';

		echo CHtml::link(CHtml::image($imgSource), array('frontProduct/view', 'url'=>$data->url), array('class'=>'thumbnail'));
	?>
</div>
<!-- Right column -->
<div class="span5">
	<?php echo CHtml::link(CHtml::encode($data->name), array('frontProduct/view', 'url'=>$data->url)) ?>
	<br>
	<?php echo StoreProduct::formatPrice($data->price) ?>
</div>

<div style="clear:both;height: 10px;"></div>
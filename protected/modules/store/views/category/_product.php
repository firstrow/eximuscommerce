<!-- Left column  -->
<div class="span2">
	<a href="" class="thumbnail">
		<img src="http://placehold.it/170x124" alt="">
	</a>
</div>
<!-- Right column -->
<div class="span5">
	<?php echo CHtml::link(CHtml::encode($data->name), array('frontProduct/view', 'url'=>$data->url)) ?>
	<br>
	<?php echo $data->price; ?>
</div>

<div style="clear:both;height: 10px;"></div>
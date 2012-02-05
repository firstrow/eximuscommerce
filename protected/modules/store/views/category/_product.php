<!-- Left column  -->
<div class="span3">
	<a href="" class="thumbnail">
		<img src="http://placehold.it/210x150" alt="">
	</a>
</div>
<!-- Right column -->
<div class="span8">
	<?php
		echo CHtml::link(CHtml::encode($data->name), array('frontProduct/view', 'url'=>$data->url));
	?>
	<br>
	<?php echo $data->price; ?>
</div>

<div style="clear:both;height: 10px;"></div>
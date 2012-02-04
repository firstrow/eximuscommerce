<!-- Left column  -->
<div class="span3">
	<img class="thumbnail" src="http://placehold.it/210x150" alt="">
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
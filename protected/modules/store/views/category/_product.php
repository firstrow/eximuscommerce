<!-- Left column  -->
<div class="span4">
	<img class="thumbnail" src="http://placehold.it/210x150" alt="">
</div>
<!-- Right column -->
<div class="span-two-thirds">
	<?php
		echo CHtml::link(CHtml::encode($data->name), array('frontProduct/view', 'url'=>$data->url));
	?>
	<br>
	<?php
		echo $data->price;
	?>
</div>

<div style="clear:both;"></div>
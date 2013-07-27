<?php
	$history = $model->getHistory();

	if(empty($history))
	{
		echo Yii::t('OrdersModule.core','Список истории пустой.');
		return;
	}
?>
<table class="orderHistory">
	<thead>
		<tr>
			<td></td>
			<td><?=Yii::t('OrdersModule.core','До');?></td>
			<td><?=Yii::t('OrdersModule.core','После');?></td>
		</tr>
	</thead>
	<tbody>
	<?php
	$class = "even";
	foreach($history as $row)
	{
		$this->renderPartial('_'.$row->handler, array(
			'data'=>$row,
			'class'=>$class
		));

		if($class==='even')
			$class='odd';
		else
			$class='even';
	}
	?>
	</tbody>
</table>
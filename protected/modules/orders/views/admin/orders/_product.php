<?php
	$data_before = $data->getDataBefore();
	$data_after  = $data->getDataAfter();
?>
<tr class="<?=$class?>">
	<td style="width: 250px">
		<a href="<?=Yii::app()->createUrl('/admin/users/default/update', array('id'=>$data->user_id))?>"><?=$data->username?></a>
		<br>
		<span class="date"><?=$data->created?></span>
	</td>
	<?php if(isset($data_before['changed'])): ?>
		<td style="width: 400px">
			<?php
				echo Yii::t('OrdersModule.admin', 'Изменил продукт ').$data_before['name'].'<br>';
				echo Yii::t('OrdersModule.admin', 'Количество: ').$data_before['quantity'];
			?>
		</td>
		<td style="width: 400px">
			<?php
				echo Yii::t('OrdersModule.admin', 'Количество: ').$data_after['quantity'];
			?>
		</td>
	<?php elseif($data_before['deleted']): ?>
		<td style="width: 800px" colspan="2">
			<?php
				echo Yii::t('OrdersModule.admin', 'Удалил продукт ').$data_before['name'].'<br>';
				echo Yii::t('OrdersModule.admin', 'Стоимость: ').$data_before['price'].'<br>';
				echo Yii::t('OrdersModule.admin', 'Количество: ').$data_before['quantity'];
			?>
		</td>
	<?php else: ?>
		<td style="width: 800px" colspan="2">
			<?php
				echo 'Добавил продукт '.$data_before['name'].'<br>';
				echo Yii::t('OrdersModule.admin', 'Стоимость: ').$data_before['price'].'<br>';
				echo Yii::t('OrdersModule.admin', 'Количество: ').$data_before['quantity'];
			?>
		</td>
	<?php endif; ?>
</tr>
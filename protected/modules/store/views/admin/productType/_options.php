<div class="row">
	<?php echo CHtml::activeLabel($model, 'name', array('required'=>true)); ?>
	<?php echo CHtml::activeTextField($model, 'name'); ?>
</div>

<div class="row">
	<label><?php echo Yii::t('StoreModule.admin', 'Атрибуты') ?></label>
	<table width="600px" class="attributesTable">
		<thead>
		<tr>
			<td><?php echo Yii::t('StoreModule.admin', 'Атрибуты продукта') ?></td>
			<td><?php echo Yii::t('StoreModule.admin', 'Доступные атрибуты') ?></td>
		</tr>
		</thead>
		<tbody>
		<tr valign="top">
			<td>
				<?php
				echo CHtml::dropDownList('attributes[]',
					null,
					CHtml::listData($model->storeAttributes, 'id', 'title'),
					array('multiple'=>true, 'class'=>'attributesList')
				);
				?>
			</td>
			<td>
				<?php
				echo CHtml::dropDownList('allAttributes',
					null,
					CHtml::listData($attributes, 'id', 'title'),
					array('multiple'=>true, 'class'=>'attributesList')
				);
				?>
			</td>
		</tr>
		</tbody>
	</table>
</div>

<?php

/**
 * Attribute options tab.
 */

Yii::app()->getClientScript()
	->registerScriptFile($this->module->assetsUrl.'/admin/attribute.options.js', CClientScript::POS_END);
?>

<style type="text/css">
	table.optionsEditTable td {
		padding: 3px;
	}
	table.optionsEditTable input[type="text"] {
		width: 200px;
	}
	table.optionsEditTable tr.copyMe {
		display: none;
	}
	table.optionsEditTable {
		cursor: pointer;
	}
</style>

<table class="optionsEditTable">
	<thead>
		<tr>
			<td></td>
			<?php foreach(Yii::app()->languageManager->languages as $l): ?>
			<td>
				<?php echo CHtml::encode($l->name) ?>
			</td>
			<?php endforeach; ?>
			<td>
				<a href="#" class="plusOne"><?php echo Yii::t('StoreModule.admin', 'Добавить') ?></a>
			</td>
		</tr>
	</thead>
	<tbody>
		<tr class="copyMe">
			<td><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></td>
			<?php foreach(Yii::app()->languageManager->languages as $l): ?>
			<td>
				<input name="sample" type="text" class="value">
			</td>
			<?php endforeach; ?>
			<td>
				<a href="#" class="deleteRow"><?php echo Yii::t('StoreModule.admin', 'Удалить') ?></a>
			</td>
		</tr>
		<?php
			if($model->options)
			{
				foreach($model->options as $o)
				{
					?>
						<tr>
							<td><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></td>
							<?php
								foreach(Yii::app()->languageManager->languages as $l):
								$o->option_translate =StoreAttributeOptionTranslate::model()->findByAttributes(array(
									'object_id'=>$o->id,
									'language_id'=>$l->id
								));
							?>
							<td>
								<input name="options[<?php echo $o->id ?>][]" type="text" value="<?php echo CHtml::encode($o->option_translate->value) ?>">
							</td>
							<?php endforeach; ?>
							<td>
								<a href="#" class="deleteRow"><?php echo Yii::t('StoreModule.admin', 'Удалить') ?></a>
							</td>
						</tr>
					<?php
				}
			}else{
		?>
			<tr>
				<td><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></td>
				<?php
				$rnd=rand(1,9999);
				foreach(Yii::app()->languageManager->languages as $l):
				?>
				<td>
					<input name="options[<?php echo $rnd ?>][]" type="text">
				</td>
				<?php endforeach; ?>
				<td>
					<a href="#" class="deleteRow"><?php echo Yii::t('StoreModule.admin', 'Удалить') ?></a>
				</td>
			</tr>
		<?php
			}
		?>
	</tbody>
</table>
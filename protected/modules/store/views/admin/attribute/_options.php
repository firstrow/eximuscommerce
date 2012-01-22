<?php
	Yii::app()
		->getClientScript()
		->registerScriptFile($this->module->assetsUrl.'/admin/attribute.options.js');
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
			<td>
				Language
			</td>
			<td>
				<a href="#" class="plusOne">Plus</a>
			</td>
		</tr>
	</thead>
	<tbody>
		<tr class="copyMe">
			<td><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></td>
			<td>
				<input name="sample" type="text" class="value">
			</td>
			<td>
				<a href="#" class="deleteRow">Delete</a>
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
							<td>
								<input name="options[<?php echo $o->id ?>][]" type="text" value="<?php echo CHtml::encode($o->value) ?>">
							</td>
							<td>
								<a href="#" class="deleteRow">Delete</a>
							</td>
						</tr>
					<?php
				}
			}else{
				?>
					<tr>
						<td><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></td>
						<td>
							<input name="options[<?php rand(1,9999) ?>][]" type="text">
						</td>
						<td>
							<a href="#" class="deleteRow">Delete</a>
						</td>
					</tr>
				<?php
			}
		?>
	</tbody>
</table>
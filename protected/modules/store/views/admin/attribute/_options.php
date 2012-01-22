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
				Russian
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

<script type="text/javascript">
	$(".optionsEditTable .plusOne").click(function(){
		var row = $(".optionsEditTable .copyMe").clone().removeClass('copyMe');
		row.appendTo(".optionsEditTable tbody");
		row.find(".value").each(function(i, el){
			$(el).attr('name', 'options['+Math.random()+'][]');
		});
		return false;
	});

	$(".optionsEditTable").delegate(".deleteRow", "click", function(){
		$(this).parent().parent().remove();

		if($(".optionsEditTable tbody tr").length == 1)
		{
			$(".optionsEditTable .plusOne").click();
		}

		return false;
	});

	$(".optionsEditTable tbody").sortable();
</script>
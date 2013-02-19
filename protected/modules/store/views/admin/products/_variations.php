<?php
/**
 * @var StoreProduct $model
 */

$this->widget('admin.widgets.schosen.SChosen', array(
	'elements'=>array()
));

Yii::app()->getClientScript()->registerScriptFile($this->module->assetsUrl.'/admin/products.variations.js', CClientScript::POS_END);

?>

<div class="variants">
	<div class="row">
		<label>Добавить атрибут</label>
		<?php
			if($model->type)
			{
				$attributes = $model->type->storeConfigurableAttributes;
				echo CHtml::dropDownList('variantAttribute', null, CHtml::listData($attributes, 'id', 'title'));
			}
		?>
		<a href="#" id="addAttribute">Добавить</a>
	</div>

	<hr>


	<div id="variantsData">
		<?php
			foreach($model->processVariants() as $row)
			{
				$this->renderPartial('variants/_table', array(
					'attribute'=>$row['attribute'],
					'options'=>$row['options']
				));
			}
		?>
	</div>
</div>
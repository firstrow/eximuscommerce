<?php if(isset($product)): ?>
	<table style="width: 70%" id="relatedProductsTable">
		<?php foreach($product->relatedProducts as $related): ?>
			<tr>
				<input type="hidden" value="<?php echo $related->id ?>" name="RelatedProductId[]">
				<td class="relatedProductLine<?php echo $related->id ?>"><?php echo $related->id ?></td>
				<td><?php echo CHtml::link($related->name, array('admin/products/update', 'id'=>$related->id), array(
					'target'=>'_blank'
				)); ?></td>
				<td><a href="#" onclick="$(this).parents('tr').remove();"><?php echo Yii::t('StoreModule.admin', 'Удалить') ?></a></td>
			</tr>
		<?php endforeach ?>
	</table>
<?php endif; ?>

<div>&nbsp;</div>

<?php

/**
 * Related products tab
 */

Yii::app()->clientScript->registerScript("rti18n",
	strtr("var deleteButtonText='{text}';", array(
		'{text}'=>Yii::t('StoreModule.admin','Удалить'),
	)),
CClientScript::POS_HEAD);

Yii::app()->getClientScript()->registerScriptFile($this->module->assetsUrl.'/admin/relatedProductsTab.js');

if(!isset($model))
{
	$model = new StoreProduct('search');
	$model->exclude = $exclude;
}

// Fix sort and pagination urls
$dataProvider = $model->search();
$dataProvider->sort->route = 'applyProductsFilter';
$dataProvider->pagination->route = 'applyProductsFilter';

$this->widget('ext.sgridview.SGridView', array(
	'dataProvider'       => $dataProvider,
	'ajaxUrl'            => Yii::app()->createUrl('/store/admin/products/applyProductsFilter', array('exclude'=>$exclude)),
	'id'                 => 'RelatedProductsGrid',
	'template'           => '{items}{summary}{pager}',
	'enableCustomActions'=> false,
	'extended'           => true,
	'enableHistory'      => false,
	'selectableRows'     => 0,
	'filter'             => $model,
	'columns' => array(
		array(
			'name'=>'id',
			'type'=>'text',
			'value'=>'$data->id',
			'filter'=>CHtml::textField('RelatedProducts[id]', $model->id)
		),
		array(
			'name'=>'name',
			'type'=>'raw',
			'value'=>'CHtml::link(CHtml::encode($data->name), array("update", "id"=>$data->id), array("target"=>"_blank"))',
			'filter'=>CHtml::textField('RelatedProducts[name]', $model->name)
		),
		array(
			'name'=>'sku',
			'value'=>'$data->sku',
			'filter'=>CHtml::textField('RelatedProducts[sku]', $model->sku)
		),
		array(
			'name'=>'price',
			'value'=>'$data->price',
			'filter'=>CHtml::textField('RelatedProducts[price]', $model->price)
		),
		array(
			'class'=>'CLinkColumn',
			'header'=>'',
			'label'=>Yii::t('StoreModule.admin','Добавить'),
			'urlExpression'=>'$data->id."/".CHtml::encode($data->name)',
			'htmlOptions'=>array(
				'onClick'=>'return AddRelatedProduct(this);'
			),
		),
	),
));

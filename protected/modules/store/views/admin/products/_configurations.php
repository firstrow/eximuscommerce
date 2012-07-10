<?php
/**
 * Confirutable products tab
 *
 * @var Controller $this
 * @var StoreProduct $product Current product
 * @var StoreProduct $model
 */

Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl.'/admin/products.configurations.js');

// For grid view we use new products instance
$model = new StoreProduct;

if(isset($_GET['ConfProduct']))
	$model->attributes = $_GET['ConfProduct'];

$columns = array(
	array(
		'class'=>'CCheckBoxColumn',
		'checked'=>(!empty($product->configurations) && !isset($clearConfigurations) && !$product->isNewRecord) ? 'true' : 'false'
	),
	array(
		'name'=>'id',
		'type'=>'text',
		'value'=>'$data->id',
		'filter'=>CHtml::textField('ConfProduct[id]', $model->id)
	),
	array(
		'name'=>'name',
		'type'=>'raw',
		'value'=>'CHtml::link(CHtml::encode($data->name), array("update", "id"=>$data->id), array("target"=>"_blank"))',
		'filter'=>CHtml::textField('ConfProduct[name]', $model->name)
	),
	array(
		'name'=>'sku',
		'value'=>'$data->sku',
		'filter'=>CHtml::textField('ConfProduct[sku]', $model->sku)
	),
	array(
		'name'=>'price',
		'value'=>'$data->price',
		'filter'=>CHtml::textField('ConfProduct[price]', $model->price)
	),
);

// Process attributes
$eavAttributes = array();
$attributeModels = StoreAttribute::model();
$attributeModels->setTableAlias('StoreAttribute');
$attributeModels = $attributeModels->findAllByPk($product->configurable_attributes);

foreach($attributeModels as $attribute)
{
	$selected = null;

	if(isset($_GET['eav'][$attribute->name]) && !empty($_GET['eav'][$attribute->name]))
	{
		$eavAttributes[$attribute->name] = $_GET['eav'][$attribute->name];
		$selected = $_GET['eav'][$attribute->name];
	}
	else
		array_push($eavAttributes, $attribute->name);

	$columns[] = array(
		'name'        => 'eav_'.$attribute->name,
		'header'      => $attribute->title,
		'htmlOptions' => array('class'=>'eav'),
		'filter'      => CHtml::dropDownList('eav['.$attribute->name.']', $selected, CHtml::listData($attribute->options, 'id', 'value'), array(
			'empty'=>'---',
		))
	);
}

if(!empty($eavAttributes))
	$model = $model->withEavAttributes($eavAttributes);

// On edit display only saved configurations
$cr = new CDbCriteria;
if(!empty($product->configurations) && !isset($clearConfigurations) && !$product->isNewRecord)
	$cr->addInCondition('t.id', $product->configurations);

$model->exclude = $product->id;
$model->use_configurations = false;

$dataProvider = $model->search(array(), $cr);
$dataProvider->pagination->pageSize = 1000;

$this->widget('ext.sgridview.SGridView', array(
	'dataProvider'=>$dataProvider,
	'ajaxUrl'=>Yii::app()->createUrl('/store/admin/products/ApplyConfigurationsFilter', array(
		'product_id'=>$product->id,
		'configurable_attributes'=>isset($_GET['StoreProduct']['configurable_attributes']) ? $_GET['StoreProduct']['configurable_attributes'] : $product->configurable_attributes,
	)),
	'id'=>'ConfigurationsProductGrid',
	'template'=>'{items}{summary}{pager}',
	'enableCustomActions'=>false,
	'enableSorting'=>false,
	'extended'=>false,
	'selectionChanged'=>'js:function(id){processConfigurableSelection(id)}',
	'selectableRows'=>2,
	'filter'=>$model,
	'columns'=>$columns,
));

?>

<script type="text/javascript">
	initConfigurationsTable();
</script>
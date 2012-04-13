<div class="form wide">
	<?php echo Yii::t('StoreModule.admin', 'Поиск:') ?> <input type="text" onkeyup='$("#StoreCategoryTree").jstree("search", $(this).val());' />
</div>

<?php

// Register scripts
Yii::app()->clientScript->registerScriptFile(
	$this->module->assetsUrl.'/admin/products.js',
	CClientScript::POS_END
);

// Insert hidden to handle main category
if($model->mainCategory)
	$mainCategory = ($model->isNewRecord) ? 0 : $model->mainCategory->id;
else
{
	if($model->type)
		$mainCategory = $model->type->main_category;
	else
		$mainCategory = 0;
}
echo CHtml::hiddenField('main_category', $mainCategory);

// Create jstree
$this->widget('ext.jstree.SJsTree', array(
	'id'=>'StoreCategoryTree',
	'data'=>StoreCategoryNode::fromArray(StoreCategory::model()->findAllByPk(1)),
	'options'=>array(
		'core'=>array(
			// Open root
			'initially_open'=>'StoreCategoryTreeNode_1',
		),
		'plugins'=>array('themes','html_data','ui','crrm', 'search','checkbox', 'cookies'),
		'checkbox'=>array(
			'two_state'=>true,
		),
		'cookies'=>array(
			'save_selected'=>false,
		),
		'ui'=>array(
			'initially_select'=>'StoreCategoryTreeNode_'.$mainCategory,
		),
	),
));

// Get categories preset
if($model->type)
{
	$presetCategories = unserialize($model->type->categories_preset);
	if(!is_array($presetCategories))
		$presetCategories = array();
}

if(isset($_POST['categories']) && !empty($_POST['categories']))
{
	foreach($_POST['categories'] as $id)
	{
		Yii::app()->getClientScript()->registerScript("checkNode{$id}", "
			$('#StoreCategoryTree').checkNode({$id});
		");
	}
}
elseif($model->isNewRecord && empty($_POST['categories']) && isset($presetCategories))
{
	foreach($presetCategories as $id)
	{
		Yii::app()->getClientScript()->registerScript("checkNode{$id}", "
			$('#StoreCategoryTree').checkNode({$id});
		");
	}
}
else
{
	// Check tree nodes
	foreach($model->categories as $c)
	{
		Yii::app()->getClientScript()->registerScript("checkNode{$c->id}", "
			$('#StoreCategoryTree').checkNode({$c->id});
		");
	}
}

Yii::app()->getClientScript()->registerCss("StoreCategoryTreeStyles","#StoreCategoryTree { width:90% }");

?>

<div class="hint" style="margin: 0">
	<br><?php echo Yii::t('StoreModule.admin',"Нажмите на название категории, чтобы сделать её главной."); ?>
</div>
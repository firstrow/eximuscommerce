<div class="form wide">
	Поиск: <input type="text" onkeyup='$("#StoreCategoryTree").jstree("search", $(this).val());' />
</div>

<?php

// Register scripts
Yii::app()->clientScript->registerScriptFile(
	$this->module->assetsUrl.'/admin/products.js',
	CClientScript::POS_END
);

// Insert hidden to handle main category
$mainCategory = ($model->isNewRecord) ? 0 : 'StoreCategoryTreeNode_'.$model->mainCategory->id;
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
			'initially_select'=>$mainCategory,
		),
	),
));

// Check tree nodes
foreach($model->categories as $c)
{
	Yii::app()->getClientScript()->registerScript("checkNode{$c->id}", "
		$('#StoreCategoryTree').checkNode({$c->id});
	");
}

Yii::app()->getClientScript()->registerCss("StoreCategoryTreeStyles","#StoreCategoryTree { width:90% }");

?>

<div class="hint" style="margin: 0">
	<br><?php echo Yii::t('StoreModule.admin',"Нажмите на название категории, чтобы сделать её главной."); ?>
</div>
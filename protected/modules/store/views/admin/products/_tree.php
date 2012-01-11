<div class="form wide">
	Поиск: <input type="text" onkeyup='$("#StoreCategoryTree").jstree("search", $(this).val());' />
</div>

<?php

// Register scripts
Yii::app()->clientScript->registerScriptFile(
	$this->module->assetsUrl.'/admin/products.js',
	CClientScript::POS_END
);

// Create jstree
$this->widget('ext.jstree.SJsTree', array(
	'id'=>'StoreCategoryTree',
	'data'=>StoreCategoryNode::fromArray(StoreCategory::model()->findAllByPk(1)),
	'options'=>array(
		'core'=>array('initially_open'=>'StoreCategoryTreeNode_1'),
		'plugins'=>array('themes','html_data','ui','crrm', 'search','checkbox','cookies'),
		'checkbox'=>array(
			'two_state'=>true,
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
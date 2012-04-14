<div class="form wide">
	<?php echo Yii::t('StoreModule.admin', 'Поиск:') ?> <input type="text" onkeyup='$("#StoreTypeCategoryTree").jstree("search", $(this).val());' />
</div>

<?php
// Create jstree
$this->widget('ext.jstree.SJsTree', array(
	'id'=>'StoreTypeCategoryTree',
	'data'=>StoreCategoryNode::fromArray(StoreCategory::model()->findAllByPk(1)),
	'options'=>array(
		'core'=>array(
			// Open root
			'initially_open'=>'StoreTypeCategoryTreeNode_1',
		),
		'plugins'=>array('themes','html_data','ui','crrm', 'search','checkbox', 'cookies'),
		'checkbox'=>array(
			'two_state'=>true,
		),
		'cookies'=>array(
			'save_selected'=>false,
		),
		'ui'=>array(
			'initially_select'=>'StoreTypeCategoryTreeNode_'.$model->main_category,
		),
	),
));

// Check tree nodes
$categories = unserialize($model->categories_preset);
if(!is_array($categories)) $categories = array();
foreach($categories as $id)
{
	Yii::app()->getClientScript()->registerScript("checkNode{$id}", "
		$('#StoreTypeCategoryTree').checkNode({$id});
	");
}

?>

<div class="hint" style="margin: 0">
	<br><?php echo Yii::t('StoreModule.admin',"Здесь вы можете указать категории, которые будут автоматически выбраны при создании продукта."); ?>
	<br><?php echo Yii::t('StoreModule.admin',"Нажмите на название категории, чтобы сделать её главной."); ?>
</div>
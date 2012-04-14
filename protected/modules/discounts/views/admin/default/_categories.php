<?php

Yii::import('store.models.*');

?>

<div class="form wide">
	<?php echo Yii::t('DiscountsModule.admin', 'Поиск:') ?> <input type="text" onkeyup='$("#StoreDiscountCategoryTree").jstree("search", $(this).val());' />
</div>

<?php
// Create jstree
$this->widget('ext.jstree.SJsTree', array(
	'id'=>'StoreDiscountCategoryTree',
	'data'=>StoreCategoryNode::fromArray(StoreCategory::model()->findAllByPk(1)),
	'options'=>array(
		'core'=>array(
			// Open root
			'initially_open'=>'StoreDiscountCategoryTreeNode_1',
		),
		'plugins'=>array('themes','html_data','ui','crrm', 'search','checkbox'),
		'checkbox'=>array(
			'two_state'=>true,
		),
	),
));

// Check tree nodes
foreach($model->categories as $id)
{
	Yii::app()->getClientScript()->registerScript("checkNode{$id}", "
		$('#StoreDiscountCategoryTree').checkNode({$id});
	");
}

?>

<div class="hint" style="margin: 0">
	<br><?php echo Yii::t('DiscountsModule.admin',"Здесь вы можете указать категории, для которых будет доступна скидка."); ?>
</div>
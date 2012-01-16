<h3>&nbsp;</h3>
<div class="form wide">
	<input type="text" style="width: 90%" onkeyup='$("#StoreCategoryTree").jstree("search", $(this).val());' />
</div>

<!--<div>-->
<!--	<a href="" >Все категории</a>-->
<!--</div>-->

<?php

// Create jstree to filter products
$this->widget('ext.jstree.SJsTree', array(
	'id'=>'StoreCategoryTreeFilter',
	'data'=>StoreCategoryNode::fromArray(StoreCategory::model()->findAllByPk(1)),
	'options'=>array(
		'core'=>array('initially_open'=>'StoreCategoryTreeFilterNode_1'),
		'plugins'=>array('themes','html_data','ui','crrm', 'search','cookies'),
		'ui'=>array(
			'initially_select'=>array('#StoreCategoryTreeFilterNode_'.(int)Yii::app()->request->getParam('category'))
		),
		'cookies'=>array(
			'save_selected'=>false,
		),
	),
));

Yii::app()->getClientScript()->registerCss("StoreCategoryTreeStyles","#StoreCategoryTree { width:90% }");

?>
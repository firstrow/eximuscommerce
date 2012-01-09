<h3>&nbsp;</h3>
<div class="form wide">
	<input type="text" style="width: 90%" onkeyup='$("#StoreCategoryTree").jstree("search", $(this).val());' />
</div>

<?php

// Register scripts
Yii::app()->clientScript->registerScriptFile(
	$this->module->assetsUrl.'/admin/category.js',
	CClientScript::POS_END
);

// Create jstree
$this->widget('ext.jstree.SJsTree', array(
	'id'=>'StoreCategoryTree',
	'data'=>StoreCategoryNode::fromArray(StoreCategory::model()->findAllByPk(1)),
	'options'=>array(
		'core'=>array('initially_open'=>'StoreCategoryTreeNode_1'),
		'plugins'=>array('themes','html_data','ui','dnd','crrm', 'search','cookies'),
		'crrm'=>array(
			'move'=>array('check_move'=>'js: function(m){
				// Disallow categories without parent.
				// At least each category must have `root` category as parent.
				var p = this._get_parent(m.r);
				if (p == -1) return false;
				return true;
			}')
		 ),
		'dnd'=>array(
			'drag_finish'=>'js:function(data){
				alert(data);
			}',
		),
		'ui'=>array(
			'initially_select'=>array('#StoreCategoryTreeNode_'.(int)Yii::app()->request->getParam('id'))
		),
	),
));

Yii::app()->getClientScript()->registerCss("StoreCategoryTreeStyles","#StoreCategoryTree { width:90% }");

?>

<div class="hint">
	<br>
	<?php echo Yii::t('StoreModule.admin',"Используйте 'drag-and-drop' для сортировки категорий."); ?>
</div>
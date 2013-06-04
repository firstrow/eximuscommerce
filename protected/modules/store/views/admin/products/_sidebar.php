<h3><?php echo Yii::t('StoreModule.admin', 'Поиск по категории') ?></h3>

<div class="form wide">
	<input type="text" style="width: 170px;float: left; margin-right: 5px;" onkeyup='$("#StoreCategoryTreeFilter").jstree("search", $(this).val());' />
	<?php
		$this->beginWidget('zii.widgets.jui.CJuiButton', array(
			'buttonType'=>'buttonset',
			'name'=>'tree-set',
			'htmlOptions'=>array(
				'style'=>'padding-top:2px;',
			)
		));
		$this->widget('zii.widgets.jui.CJuiButton', array(
			'name'=>'button1',
			'buttonType'=>'button',
			'caption'=>Yii::t('StoreModule.admin', 'Развернуть все'),
			'onclick'=>'js:function(){
				 $("#StoreCategoryTreeFilter").jstree("open_all");
			}',
			'options'=>array(
				'text'=>false,
				'icons'=>array('primary'=>'ui-icon-triangle-1-s'),
			),
		));

		$this->widget('zii.widgets.jui.CJuiButton', array(
			'name'=>'button12',
			'buttonType'=>'button',
			'caption'=>Yii::t('StoreModule.admin', 'Свернуть все'),
			'onclick'=>'js:function(){
				 $("#StoreCategoryTreeFilter").jstree("close_all");
				 $("#StoreCategoryTreeFilter").jstree("open_node", "#StoreCategoryTreeFilterNode_1", false, true);
			}',
			'options'=>array(
				'text'=>false,
				'icons'=>array('primary'=>'ui-icon-triangle-1-n')
			),
		));
		$this->endWidget();
	?>

</div>

<div style="clear: both;"></div>

<?php

// Create jstree to filter products
$this->widget('ext.jstree.SJsTree', array(
	'id'=>'StoreCategoryTreeFilter',
	'data'=>StoreCategoryNode::fromArray(StoreCategory::model()->findAllByPk(1), array('displayCount'=>true)),
	'options'=>array(
		'core'=>array('initially_open'=>'StoreCategoryTreeFilterNode_1'),
		'plugins'=>array('themes','html_data','ui','crrm', 'search'),
		'cookies'=>array(
			'save_selected'=>false,
		),
	),
));

// Category id to select in sidebar.
$activeCategoryId = Yii::app()->request->getQuery('category', 0);

if(is_array($activeCategoryId))
	$activeCategoryId=0;

Yii::app()->getClientScript()->registerScript('insertAllCategory', '
$("#StoreCategoryTreeFilter").bind("loaded.jstree", function (event, data) {
	$(this).jstree("create",-1,false,{attr:{id:"StoreCategoryTreeFilterNode_0"}, data:{title:"'.Yii::t('StoreModule.admin', 'Все категории').'"}},false,true);
	$(this).jstree("select_node","#StoreCategoryTreeFilterNode_'.$activeCategoryId.'");
});
');

Yii::app()->getClientScript()->registerCss("StoreCategoryTreeStyles","
	#StoreCategoryTree { width:90% }
	#StoreCategoryTreeFilter {width: 255px}
");


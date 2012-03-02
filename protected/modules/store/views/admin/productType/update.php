<?php

/**
 * Create/update product types
 *
 * @var $this SAdminController
 */

$this->topButtons = $this->widget('application.modules.admin.widgets.SAdminTopButtons', array(
	'formId'=>'StoreProductTypeForm',
	//'langSwitcher'=>!$model->isNewRecord,
	'deleteAction'=>$this->createUrl('/store/admin/productType/delete', array('id'=>$model->id))
));

$title = ($model->isNewRecord) ? Yii::t('StoreModule.admin', 'Создание нового продукта') :
	Yii::t('StoreModule.admin', 'Редактирование типа продукта');

$this->breadcrumbs = array(
	'Home'=>$this->createUrl('/admin'),
	Yii::t('StoreModule.admin', 'Типы продуктов')=>$this->createUrl('index'),
	($model->isNewRecord) ? Yii::t('StoreModule.admin', 'Создание нового продукта') : CHtml::encode($model->name),
);

$this->pageHeader = $title;

// Register scripts
Yii::app()->clientScript->registerScriptFile(
	$this->module->assetsUrl.'/admin/productType.update.js',
	CClientScript::POS_END
);

?>

<div class="form wide padding-all">
	<?php
	echo CHtml::beginForm('', 'post',array(
		'id'=>'StoreProductTypeForm'
	));
	echo CHtml::errorSummary($model);

	echo CHtml::hiddenField('main_category', $model->main_category);

	$this->widget('ext.sidebartabs.SAdminSidebarTabs', array(
		'tabs'=>array(
			Yii::t('StoreModule.admin','Опции')     => $this->renderPartial('_options', array('model'=>$model,'attributes'=>$attributes), true),
			Yii::t('StoreModule.admin','Категории') => $this->renderPartial('_tree', array('model'=>$model), true),
		)
	));
	echo CHtml::endForm(); ?>
</div><!-- end form -->

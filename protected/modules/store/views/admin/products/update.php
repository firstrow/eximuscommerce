<?php

/**
 * Create/update product
 *
 * @var $model StoreProduct
 */
$this->topButtons = $this->widget('application.modules.admin.widgets.SAdminTopButtons', array(
	'form'=>$form,
	//'langSwitcher'=>!$model->isNewRecord,
	'deleteAction'=>$this->createUrl('/store/admin/products/delete', array('id'=>$model->id))
));

$title = ($model->isNewRecord) ? Yii::t('StoreModule.admin', 'Создание продукта') :
	Yii::t('StoreModule.admin', 'Редактирование продукта');

$this->breadcrumbs = array(
	'Home'=>$this->createUrl('/admin'),
	Yii::t('StoreModule.admin', 'Продукты')=>$this->createUrl('index'),
	($model->isNewRecord) ? Yii::t('StoreModule.admin', 'Создание продукта') : CHtml::encode($model->name),
);

if($model->type)
	$title .= ' "'.CHtml::encode($model->type->name).'"';

$this->pageHeader = $title;

$this->widget('application.modules.admin.widgets.schosen.SChosen', array(
	'elements'=>array('StoreProduct_manufacturer_id','StoreProduct_is_active', 'StoreProduct_use_configurations')
));

?>

<div class="form wide padding-all">
<?php
	if($model->isNewRecord && !$model->type_id)
	{
		// Display "choose type" form
		echo CHtml::form('', 'get');

		// Type
		echo CHtml::openTag('div', array('class'=>'row'));
		echo CHtml::activeLabel($model, 'type_id');
		echo CHtml::activeDropDownList($model, 'type_id', CHtml::listData(StoreProductType::model()->orderByName()->findAll(), 'id', 'name'));
		echo CHtml::closeTag('div');

		// Use configurations
		echo CHtml::openTag('div', array('class'=>'row'));
		echo CHtml::activeLabel($model, 'use_configurations');
		echo CHtml::activeDropDownList($model, 'use_configurations', array(
			0=>Yii::t('StoreModule.admin', 'Нет'),
			1=>Yii::t('StoreModule.admin', 'Да'),
		));
		echo CHtml::closeTag('div');

		// Available attributes
		echo CHtml::openTag('div', array('id'=>'availableAttributes', 'class'=>'row'));
		echo CHtml::closeTag('div');

		echo CHtml::openTag('div', array('class'=>'row rowInput'));
		echo CHtml::submitButton(Yii::t('StoreModule.admin', 'Создать'), array('name'=>false));
		echo CHtml::closeTag('div');
		echo CHtml::endForm();

		$this->widget('application.modules.admin.widgets.schosen.SChosen', array(
			'elements'=>array('StoreProduct_type_id')
		));
	}
	else
		echo $form->asTabs();
?>
</div>

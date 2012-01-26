<?php

	/**
	 * Create/update product
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
		'elements'=>array('StoreProduct_manufacturer_id','StoreProduct_is_active')
	));

?>

<div class="form wide padding-all">
	<?php
		/**
		 * @var $model StoreProduct
		 */
		if($model->isNewRecord && !$model->type_id)
		{
			// Display "choose type" form
			echo CHtml::form('', 'get');
			echo CHtml::activeLabel($model, 'type_id');
			echo CHtml::dropDownList('type_id',$model->type_id, CHtml::listData(StoreProductType::model()->findAll(), 'id', 'name'));
			echo CHtml::openTag('div', array('class'=>'rowInput'));
			echo '<br>';
			echo CHtml::submitButton(Yii::t('StoreModule.admin', 'Создать'), array('name'=>false));
			echo CHtml::closeTag('div');
			echo CHtml::endForm();

			$this->widget('application.modules.admin.widgets.schosen.SChosen', array(
				'elements'=>array('type_id')
			));
		}
		else
		{
			echo $form->asTabs();
		}
	?>
</div>

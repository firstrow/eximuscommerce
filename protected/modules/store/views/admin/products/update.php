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

	$this->pageHeader = $title;

	$this->widget('application.modules.admin.widgets.schosen.SChosen', array(
		'elements'=>array('StoreProduct_manufacturer_id','StoreProduct_is_active')
	));

?>

<div class="form wide padding-all">
	<?php echo $form->asTabs(); ?>
</div>

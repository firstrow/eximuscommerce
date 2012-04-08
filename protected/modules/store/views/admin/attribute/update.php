<?php

/**
 * Create/update attribute
 */

	$this->topButtons = $this->widget('application.modules.admin.widgets.SAdminTopButtons', array(
		'form'=>$form,
		'langSwitcher'=>!$model->isNewRecord,
		'deleteAction'=>$this->createUrl('/store/admin/attribute/delete', array('id'=>$model->id))
	));

	$title = ($model->isNewRecord) ? Yii::t('StoreModule.admin', 'Создание атрибута') :
		Yii::t('StoreModule.admin', 'Редактирование атрибута');

	$this->breadcrumbs = array(
		'Home'=>$this->createUrl('/admin'),
		Yii::t('StoreModule.admin', 'Атрибуты')=>$this->createUrl('index'),
		($model->isNewRecord) ? Yii::t('StoreModule.admin', 'Создание атрибута') : CHtml::encode($model->name),
	);

	$this->pageHeader = $title;

?>

<div class="form wide padding-all">
	<?php echo $form->asTabs(); ?>
</div>
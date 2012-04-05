<?php

/**
 * Create/update manufacturer
 */

$this->topButtons = $this->widget('application.modules.admin.widgets.SAdminTopButtons', array(
	'form'=>$form,
	'langSwitcher'=>!$model->isNewRecord,
	'deleteAction'=>$this->createUrl('/store/admin/manufacturer/delete', array('id'=>$model->id))
));

$title = ($model->isNewRecord) ? Yii::t('StoreModule.admin', 'Создание производителя') :
	Yii::t('StoreModule.admin', 'Редактирование производителя');

$this->breadcrumbs = array(
	'Home'=>$this->createUrl('/admin'),
	Yii::t('StoreModule.admin', 'Производители')=>$this->createUrl('index'),
	($model->isNewRecord) ? Yii::t('StoreModule.admin', 'Создание производителя') : CHtml::encode($model->name),
);

$this->pageHeader = $title;

?>

<div class="form wide padding-all">
	<?php echo $form->asTabs(); ?>
</div>
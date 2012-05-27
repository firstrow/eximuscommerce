<?php

/**
 * Create/update payment methods
 */

Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl.'/admin/paymentMethod.update.js');

$this->topButtons = $this->widget('admin.widgets.SAdminTopButtons', array(
	'form'=>$form,
	'langSwitcher'=>!$model->isNewRecord,
	'deleteAction'=>$this->createUrl('/store/admin/paymentMethod/delete', array('id'=>$model->id))
));

$title = ($model->isNewRecord) ? Yii::t('StoreModule.admin', 'Создание способа оплаты') :
	Yii::t('StoreModule.admin', 'Редактирование способа оплаты');

$this->breadcrumbs = array(
	'Home'=>$this->createUrl('/admin'),
	Yii::t('StoreModule.admin', 'Способы оплаты')=>$this->createUrl('index'),
	($model->isNewRecord) ? Yii::t('StoreModule.admin', 'Создание способа оплаты') : CHtml::encode($model->name),
);

$this->pageHeader = $title;

?>

<div class="form wide padding-all">
	<?php echo $form; ?>
</div>
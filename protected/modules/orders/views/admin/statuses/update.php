<?php

/**
 * Create/update status
 */

$this->topButtons = $this->widget('admin.widgets.SAdminTopButtons', array(
	'form'=>$form,
	'deleteAction'=>$this->createUrl('/orders/admin/statuses/delete', array('id'=>$model->id))
));

$title = ($model->isNewRecord) ? Yii::t('OrdersModule.admin', 'Создание статуса') :
	Yii::t('OrdersModule.admin', 'Редактирование статуса');

$this->breadcrumbs = array(
	'Home'=>$this->createUrl('/admin'),
	Yii::t('OrdersModule.admin', 'Стасусы заказов')=>$this->createUrl('index'),
	($model->isNewRecord) ? Yii::t('OrdersModule.admin', 'Создание статуса') : CHtml::encode($model->name),
);

$this->pageHeader = $title;

?>

<div class="form wide padding-all">
	<?php echo $form; ?>
</div>
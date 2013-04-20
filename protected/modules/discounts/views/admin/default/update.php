<?php

/**
 * Create/update discount
 *
 * @var $model Discount
 */

$this->topButtons = $this->widget('application.modules.admin.widgets.SAdminTopButtons', array(
	'form'=>$form,
	'deleteAction'=>$this->createUrl('/discounts/admin/default/delete', array('id'=>$model->id))
));

$title = ($model->isNewRecord) ? Yii::t('DiscountsModule.admin', 'Создание скидки') :
	Yii::t('DiscountsModule.admin', 'Редактирование скидки');

$this->breadcrumbs = array(
	'Home'=>$this->createUrl('/admin'),
	Yii::t('DiscountsModule.admin', 'Скидки')=>$this->createUrl('index'),
	($model->isNewRecord) ? Yii::t('DiscountsModule.admin', 'Создание скидки') : CHtml::encode($model->name),
);

$this->pageHeader = $title;

$this->widget('application.modules.admin.widgets.schosen.SChosen', array(
	'elements'=>array('Discount_manufacturers', 'Discount_userRoles')
));

Yii::app()->clientScript->registerScriptFile(
	$this->module->assetsUrl.'/admin/default.update.js',
	CClientScript::POS_END
);

?>

<div class="form wide padding-all">
	<?php echo $form->asTabs(); ?>
</div>
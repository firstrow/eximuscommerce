<?php

/**
 * Create/update category
 */

$this->topButtons = $this->widget('application.modules.admin.widgets.SAdminTopButtons', array(
	'form'=>$form,
	'langSwitcher'=>!$model->isNewRecord,
	'deleteAction'=>$this->createUrl('/store/admin/category/delete', array('id'=>$model->id))
));

$title = ($model->isNewRecord) ? Yii::t('StoreModule.admin', 'Создание категории') :
	Yii::t('StoreModule.admin', 'Редактирование категории');

$this->breadcrumbs = array(
	'Home'=>$this->createUrl('/admin'),
	Yii::t('StoreModule.admin', 'Категории')=>$this->createUrl('index'),
	($model->isNewRecord) ? Yii::t('StoreModule.admin', 'Создание категории') : CHtml::encode($model->name),
);

$this->pageHeader = $title;

$this->widget('application.modules.admin.widgets.schosen.SChosen', array(
	'elements'=>array('StoreCategory_parent_id')
));

/**
 * @var $this Controller
 */
$this->sidebarContent = $this->renderPartial('_sidebar', array(
	'model'=>$model,
), true);
?>

<div class="form wide">
	<?php echo $form->asTabs(); ?>
</div>

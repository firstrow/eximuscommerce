<?php

/**
 * Create/update comment
 *
 * @var $model Comment
 */

$this->topButtons = $this->widget('admin.widgets.SAdminTopButtons', array(
	'form'         => $form,
	'deleteAction' => $this->createUrl('/comments/admin/comments/delete', array('id'=>$model->id)),
	'template'     => array('history_back','save','delete')
));

$title = Yii::t('CommentsModule.admin', 'Редактирование комментария');

$this->breadcrumbs = array(
	'Home'=>$this->createUrl('/admin'),
	Yii::t('CommentsModule.admin', 'Комментарии')=>$this->createUrl('index'),
	CHtml::encode($model->email),
);

$this->pageHeader = $title;

?>

<div class="form wide padding-all">
	<?php echo $form; ?>
</div>
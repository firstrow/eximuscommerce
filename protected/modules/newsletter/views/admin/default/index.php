<?php

$this->pageHeader = 'Рассылка писем';

$this->breadcrumbs = array(
	'Home'=>$this->createUrl('/admin'),
	Yii::t('NewsletterModule.admin', 'Модули')=>Yii::app()->createUrl('/core/admin/systemModules'),
	Yii::t('NewsletterModule.admin', 'Рассылка писем')
);

?>

<div class="form wide padding-all">
	<?php $form=$this->beginWidget('CActiveForm'); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->label($model,'subject'); ?>
		<?php echo $form->textField($model,'subject') ?>
		<span class="required"> *</span>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sender_name'); ?>
		<?php echo $form->textField($model,'sender_name') ?>
		<span class="required"> *</span>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sender_email'); ?>
		<?php echo $form->textField($model,'sender_email') ?>
		<span class="required"> *</span>
	</div>

	<div class="row">
		<?php echo $form->label($model,'body'); ?>
		<?php echo $form->textArea($model,'body') ?>
		<span class="required"> *</span>
	</div>

	<div class="row submit">
		<label>&nbsp;</label>
		<?php echo CHtml::submitButton(Yii::t('NewsletterModule.admin', 'Отправить')); ?>
	</div>

	<?php $this->endWidget(); ?>
</div><!-- form -->


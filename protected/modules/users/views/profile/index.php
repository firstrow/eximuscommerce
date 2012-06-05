<?php

/**
 * @var $profile UserProfile
 * @var $user User
 * @var $form CActiveForm
 * @var $changePasswordForm ChangePasswordForm
 */
?>
<h1 class="has_background"><?php echo Yii::t('UsersModule.core', 'Личный кабинет'); ?></h1>

<div class="form wide padding-all">
	<?php $form=$this->beginWidget('CActiveForm'); ?>

	<?php echo $form->errorSummary(array($profile, $user)); ?>

	<div class="row">
		<?php echo $form->label($profile,'full_name'); ?>
		<?php echo $form->textField($profile,'full_name') ?>
		<span class="required"> *</span>
	</div>

	<div class="row">
		<?php echo $form->label($user,'email'); ?>
		<?php echo $form->textField($user,'email') ?>
		<span class="required"> *</span>
	</div>

	<div class="row">
		<?php echo $form->label($profile,'phone'); ?>
		<?php echo $form->textField($profile,'phone') ?>
	</div>

	<div class="row">
		<?php echo $form->label($profile,'delivery_address'); ?>
		<?php echo $form->textArea($profile,'delivery_address') ?>
	</div>

	<div class="row submit">
		<label>&nbsp;</label>
		<?php echo CHtml::submitButton(Yii::t('UsersModule.admin', 'Сохранить')); ?>
	</div>

	<?php $this->endWidget(); ?>
</div><!-- form -->

<div style="clear: both;"></div>

<div class="form wide padding-all">
	<?php $form=$this->beginWidget('CActiveForm'); ?>

	<?php echo $form->errorSummary($changePasswordForm); ?>

	<div class="row">
		<label></label>
		<b><?php echo Yii::t('UsersModule.admin', 'Изменить пароль'); ?></b>
	</div>

	<div class="row">
		<?php echo $form->label($changePasswordForm,'current_password'); ?>
		<?php echo $form->passwordField($changePasswordForm,'current_password') ?>
	</div>

	<div class="row">
		<?php echo $form->label($changePasswordForm,'new_password'); ?>
		<?php echo $form->passwordField($changePasswordForm,'new_password') ?>
	</div>

	<div class="row submit">
		<label>&nbsp;</label>
		<?php echo CHtml::submitButton(Yii::t('UsersModule.admin', 'Изменить')); ?>
	</div>

	<?php $this->endWidget(); ?>
</div><!-- form -->
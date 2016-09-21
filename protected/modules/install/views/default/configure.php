<?php

/**
 * @var $form CActiveForm
 */
?>

<div class="progress">
	1→<span class="active">2</span>→3→4
</div>

<h1><?php echo Yii::t('InstallModule.core','Шаг 2. Подключение к БД.') ?></h1>

<div class="line"></div>

<div class="form wide">
	<?php $form=$this->beginWidget('CActiveForm'); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->label($model,'dbHost'); ?>
		<?php echo $form->textField($model,'dbHost') ?>
		<span class="required"> *</span>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dbName'); ?>
		<?php echo $form->textField($model,'dbName') ?>
		<span class="required"> *</span>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dbUserName'); ?>
		<?php echo $form->textField($model,'dbUserName') ?>
		<span class="required"> *</span>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dbPassword'); ?>
		<?php echo $form->passwordField($model,'dbPassword') ?>
	</div>

	<div class="row buttons">
		<label style="width:300px;"><?php echo $form->checkBox($model,'installDemoData') ?> <?php echo $model->getAttributeLabel('installDemoData') ?></label>
	</div>

	<div class="row buttons">
		<input type="submit" value="<?php echo Yii::t('InstallModule.core','Установить') ?>" onclick="this.disabled=true;this.value='Установка...';this.form.submit();">
	</div>

	<?php $this->endWidget(); ?>
</div>
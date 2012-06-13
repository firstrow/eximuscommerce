
<h1><?php echo Yii::t('InstallModule.core','Шаг 2. Настройка.') ?></h1>

<div class="line"></div>

<div class="form wide">
	<?php $form=$this->beginWidget('CActiveForm'); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->label($model,'siteName'); ?>
		<?php echo $form->textField($model,'siteName') ?>
		<span class="required"> *</span>
	</div>

	<h3><?php echo Yii::t('InstallModule.core','Подключение к БД') ?></h3>

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
		<?php echo $form->textField($model,'dbPassword') ?>
		<span class="required"> *</span>
	</div>

	<h3><?php echo Yii::t('InstallModule.core','Учётная запись администратора') ?></h3>

	<div class="row">
		<?php echo $form->label($model,'adminLogin'); ?>
		<?php echo $form->textField($model,'adminLogin') ?>
		<span class="required"> *</span>
	</div>

	<div class="row">
		<?php echo $form->label($model,'adminEmail'); ?>
		<?php echo $form->textField($model,'adminEmail') ?>
		<span class="required"> *</span>
	</div>

	<div class="row">
		<?php echo $form->label($model,'adminPassword'); ?>
		<?php echo $form->textField($model,'adminPassword') ?>
		<span class="required"> *</span>
	</div>

	<div class="row buttons">
		<input type="submit" value="<?php echo Yii::t('InstallModule.core','Установить') ?>">
	</div>

	<?php $this->endWidget(); ?>
</div>
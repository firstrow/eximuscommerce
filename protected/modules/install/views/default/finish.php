<div class="progress">
	1→2→<span class="active">3</span>→4
</div>

<h1><?php echo Yii::t('InstallModule.core','Шаг 3. Настройка.') ?></h1>

<div class="line"></div>

<div class="form wide">
	<?php $form=$this->beginWidget('CActiveForm'); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->label($model,'siteName'); ?>
		<?php echo $form->textField($model,'siteName') ?>
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
		<?php echo $form->passwordField($model,'adminPassword') ?>
		<span class="required"> *</span>
	</div>

	<div class="row buttons">
		<input type="submit" value="<?php echo Yii::t('InstallModule.core','Сохранить') ?>">
	</div>

	<?php $this->endWidget(); ?>
</div>
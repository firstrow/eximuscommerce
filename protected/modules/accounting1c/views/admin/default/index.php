<?php

$this->pageHeader = Yii::t('Accounting1cModule.admin', '1С бухгалтерия');

$this->breadcrumbs = array(
	'Home'=>$this->createUrl('/admin'),
	Yii::t('Accounting1cModule.admin', 'Модули')=>Yii::app()->createUrl('/core/admin/systemModules'),
	Yii::t('Accounting1cModule.admin', '1С бухгалтерия')
);

?>

<div class="form wide padding-all">
	<?php $form=$this->beginWidget('CActiveForm'); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->label($model,'ip'); ?>
		<?php echo $form->textField($model,'ip') ?>
		<span class="required"> *</span>
		<div class="hint"><?php echo Yii::t('Accounting1cModule.admin', 'Укажите IP сервера 1C  с которого разрешено принимать подключения'); ?></div>
	</div>

	<div class="row">
		<?php echo $form->label($model,'password'); ?>
		<?php echo $form->textField($model,'password') ?>
		<span class="required"> *</span>
		<div class="hint"><?php echo Yii::t('Accounting1cModule.admin', 'Пароль доступа'); ?></div>
		<div class="hint"><?php echo Yii::t('Accounting1cModule.admin', 'Сcылка импорта:') ?> /accounting1c/default/$password</div>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tempdir'); ?>
		<?php echo $form->textField($model,'tempdir') ?>
		<span class="required"> *</span>
		<div class="hint"><?php echo Yii::t('Accounting1cModule.admin', 'Путь к временной директории для загрузки xml файлов и изображений'); ?></div>
	</div>

	<div class="row submit">
		<label>&nbsp;</label>
		<?php echo CHtml::submitButton(Yii::t('Accounting1cModule.admin', 'Сохранить')); ?>
	</div>

	<?php $this->endWidget(); ?>
</div><!-- form -->

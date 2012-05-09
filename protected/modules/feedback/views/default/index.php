<?php

/**
 * @var $this Controller
 */

$this->pageTitle = Yii::t('FeedbackModule.core', 'Обратная связь');

?>

<h1 class="has_background"><?php echo Yii::t('FeedbackModule.core', 'Обратная связь') ?></h1>


<div class="form wide">
<?php $form=$this->beginWidget('CActiveForm'); ?>

		<!-- Display errors  -->
		<?php echo $form->errorSummary($model); ?>

		<div class="row">
			<?php echo CHtml::activeLabel($model,'name', array('required'=>true)); ?>
			<?php echo CHtml::activeTextField($model,'name'); ?>
		</div>

		<div class="row">
			<?php echo CHtml::activeLabel($model,'email', array('required'=>true)); ?>
			<?php echo CHtml::activeTextField($model,'email'); ?>
		</div>

		<div class="row">
			<?php echo CHtml::activeLabel($model,'message', array('required'=>true)); ?>
			<?php echo CHtml::activeTextArea($model,'message'); ?>
		</div>

		<?php if(Yii::app()->settings->get('feedback', 'enable_captcha')): ?>
		<div class="row">
			<label><?php $this->widget('CCaptcha', array('clickableImage'=>true,'showRefreshButton'=>false)) ?></label>
			<?php echo CHtml::activeTextField($model, 'code')?>
		</div>
		<?php endif; ?>

		<div class="row buttons">
			<button type="submit" class="blue_button"><?php echo Yii::t('FeedbackModule.core', 'Отправить') ?></button>
		</div>
	</fieldset>
<?php $this->endWidget(); ?>
</div>
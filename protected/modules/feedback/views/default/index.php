<?php

/**
 * @var $this Controller
 */

$this->pageTitle = Yii::t('FeedbackModule.core', 'Обратная связь');

?>

<?php $form=$this->beginWidget('CActiveForm', array('htmlOptions'=>array('class'=>'form-horizontal'))); ?>
	<fieldset>
		<legend><?php echo Yii::t('FeedbackModule.core', 'Обратная связь') ?></legend>

		<!-- Display errors  -->
		<?php if($model->hasErrors()): ?>
		<div class="alert alert-error">
			<?php echo $form->errorSummary($model); ?>
		</div>
		<?php endif; ?>

		<!-- Display succes message-->
		<?php if(Yii::app()->user->getFlash('feedback_send')): ?>
		<div class="alert alert-success">
				<?php echo Yii::t('FeedbackModule', 'Спасибо. Ваше сообщение отправлено.'); ?>
		</div>
		<?php endif ?>

		<div class="control-group">
			<?php echo CHtml::activeLabel($model,'name'); ?>
			<div class="controls">
				<?php echo CHtml::activeTextField($model,'name'); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::activeLabel($model,'email'); ?>
			<div class="controls">
				<?php echo CHtml::activeTextField($model,'email'); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::activeLabel($model,'message'); ?>
			<div class="controls">
				<?php echo CHtml::activeTextArea($model,'message'); ?>
			</div>
		</div>
		<div class="form-actions">
			<button type="submit" class="btn btn-primary"><?php echo Yii::t('FeedbackModule.core', 'Отправить') ?></button>
		</div>
	</fieldset>
<?php $this->endWidget(); ?>
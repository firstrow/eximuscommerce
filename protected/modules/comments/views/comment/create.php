<?php
/**
 * @var $this FrontProductController
 * @var $form CActiveForm
 */

// Load module
$module = Yii::app()->getModule('comments');
// Validate and save comment on post request
$comment = $module->processRequest($model);
// Load model comments
$comments = Comment::getObjectComments($model);

// Display comments
if(!empty($comments))
{
	echo CHtml::openTag('h3');
	echo 'Отзывы';
	echo CHtml::closeTag('h3');
	foreach($comments as $row)
	{
	?>
	<div class="row">
		<div class="span7">
			<h4><?php echo CHtml::encode($row->name); ?> <small><?php echo $row->created; ?></small></h4>
			<?php echo nl2br(CHtml::encode($row->text)); ?>
			<hr>
		</div>
	</div>
	<?php
	}
}

?>

<h3><?php echo Yii::t('CommentsModule.core', 'Оставить отзыв') ?></h3>
<div class="form wide">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'comment-create-form',
	'enableAjaxValidation'=>false,
)); ?>

<?php if(Yii::app()->user->isGuest): ?>
	<div class="row">
		<?php echo $form->labelEx($comment,'name'); ?>
		<?php echo $form->textField($comment,'name'); ?>
		<?php echo $form->error($comment,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($comment,'email'); ?>
		<?php echo $form->textField($comment,'email'); ?>
		<?php echo $form->error($comment,'email'); ?>
	</div>
<?php endif; ?>

	<div class="row">
		<?php echo $form->labelEx($comment,'text'); ?>
		<?php echo $form->textArea($comment,'text', array('class'=>'span5','rows'=>5)); ?>
		<?php echo $form->error($comment,'text'); ?>
	</div>

	<?php if(Yii::app()->user->isGuest): ?>
	<div class="row">
		<?php echo CHtml::activeLabelEx($comment, 'verifyCode')?>
		<? $this->widget('CCaptcha', array(
			'clickableImage'=>true,
			'showRefreshButton'=>false,
		)) ?>
		<br/>
		<label>&nbsp;</label>
		<?php echo CHtml::activeTextField($comment, 'verifyCode')?>
		<?php echo $form->error($comment,'verifyCode'); ?>
	</div>
	<?endif?>

	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('CommentsModule.core', 'Отправить')); ?>
	</div>

<?php $this->endWidget(); ?><!-- /form -->
</div>
<?php
/**
 * @var $this FrontProductController
 */

$module = Yii::app()->getModule('comments');
$comment = new Comment();

// Load model comments
$comments = Comment::model()
	->orderByCreated()
	->findAllByAttributes(array(
		'class_name'=>get_class($model),
		'object_pk'=>$model->id
));

if(Yii::app()->request->isPostRequest)
{
	$comment->attributes = Yii::app()->request->getPost('Comment');

	if($comment->validate())
	{
		$comment->class_name = get_class($model);
		$comment->object_pk = $model->id;
		$comment->save();

		// Refresh page
		$this->refresh();
	}
}

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
			<?php echo CHtml::encode($row->text); ?>
			<hr>
		</div>
	</div>
	<?php
	}
}

?>

<div class="form">
	<h3>Оставить отзыв</h3>
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'comment-create-form',
		'enableAjaxValidation'=>false,
		'htmlOptions'=>array('class'=>'well'),
	)); ?>

	<div class="control-group">
		<?php echo $form->labelEx($comment,'name'); ?>
		<?php echo $form->textField($comment,'name'); ?>
		<?php echo $form->error($comment,'name'); ?>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($comment,'email'); ?>
		<?php echo $form->textField($comment,'email'); ?>
		<?php echo $form->error($comment,'email'); ?>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($comment,'text'); ?>
		<?php echo $form->textArea($comment,'text', array('class'=>'span5','rows'=>5)); ?>
		<?php echo $form->error($comment,'text'); ?>
	</div>

	<div class="control-group buttons">
		<?php echo CHtml::submitButton('Оставить отзыв', array('class'=>'btn')); ?>
	</div>

	<?php $this->endWidget(); ?>
</div><!-- form -->
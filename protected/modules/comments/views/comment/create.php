<?php
/**
 * @var $this FrontProductController
 */

$module = Yii::app()->getModule('comments');
$comment = new Comment();

// Load model comments
$comments = Comment::model()
	->approved()
	->orderByCreatedAsc()
	->findAllByAttributes(array(
		'class_name'=>get_class($model),
		'object_pk'=>$model->id
));

if(Yii::app()->request->isPostRequest)
{
	$comment->attributes = Yii::app()->request->getPost('Comment');

	if(!Yii::app()->user->isGuest)
	{
		$comment->name = Yii::app()->user->name;
		$comment->email = Yii::app()->user->email;
	}

	if($comment->validate())
	{
		$comment->class_name = get_class($model);
		$comment->object_pk = $model->id;
		$comment->user_id = Yii::app()->user->isGuest ? 0 : Yii::app()->user->id;
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

	<h3>Оставить отзыв</h3>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'comment-create-form',
	'enableAjaxValidation'=>false,

)); ?>

<?php if(Yii::app()->user->isGuest): ?>
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
<?php endif; ?>

	<div class="control-group">
		<?php echo $form->labelEx($comment,'text'); ?>
		<?php echo $form->textArea($comment,'text', array('class'=>'span5','rows'=>5)); ?>
		<?php echo $form->error($comment,'text'); ?>
	</div>

	<div class="control-group">
		<?php echo CHtml::submitButton('Оставить отзыв', array('class'=>'btn')); ?>
	</div>

<?php $this->endWidget(); ?><!-- /form -->
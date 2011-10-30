<?php
	// Set meta tags
	$this->pageTitle = ($model->meta_title) ? $model->meta_title : $model->title;
	$this->pageKeywords = $model->meta_keywords;
	$this->pageDescription = $model->meta_description;
?>

<h3><?php echo CHtml::encode($model->title) ?></h3>
<p>
	<?php echo CHtml::encode($model->short_description) ?>
</p>
<p>
	<?php echo CHtml::encode($model->full_description) ?>
</p>
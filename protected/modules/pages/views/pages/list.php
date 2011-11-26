<?php
	// Set meta tags
	$this->pageTitle = ($model->meta_title) ? $model->meta_title : $model->name;
	$this->pageKeywords = $model->meta_keywords;
	$this->pageDescription = $model->meta_description;

	$this->breadcrumbs = array(
		$model->name
    );
?>

<?php if (sizeof($pages) > 0): ?>
	<?php foreach ($pages as $page): ?>
		<?php echo $page->title ?><br/>
	<?php endforeach ?>
<?php else: ?>
	<?php echo Yii::t('В категории нет страниц.', 'В категории нет страниц.') ?>
<?php endif ?>

<?php $this->widget('CLinkPager', array(
    'pages' => $pagination,
)) ?>
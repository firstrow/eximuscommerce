<?php

/**
 * View category pages
 * @var PageCategory $model
 */

// Set meta tags
$this->pageTitle = ($model->meta_title) ? $model->meta_title : $model->name;
$this->pageKeywords = $model->meta_keywords;
$this->pageDescription = $model->meta_description;
?>

<h1 class="has_background"><?php echo $model->name ?></h1>
<p>
	<?php if (sizeof($pages) > 0): ?>
		<?php foreach ($pages as $page): ?>
			<?php echo CHtml::link($page->title, array('/pages/pages/view', 'url'=>$page->url)); ?><br/>
		<?php endforeach ?>
	<?php else: ?>
		<?php echo Yii::t('PagesModule.core', 'В категории нет страниц.') ?>
	<?php endif ?>

	<?php $this->widget('CLinkPager', array(
		'pages' => $pagination,
	)) ?>
</p>
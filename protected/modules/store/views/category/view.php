<?php

/**
 * Category view
 * @var $model StoreCategory
 * @var $provider CActiveDataProvider
 * @var $categoryAttributes
 */

// Set meta tags
$this->pageTitle = ($this->model->meta_title) ? $this->model->meta_title : $this->model->name;
$this->pageKeywords = $this->model->meta_keywords;
$this->pageDescription = $this->model->meta_description;

// Create breadcrumbs
$ancestors = $this->model->excludeRoot()->ancestors()->findAll();

foreach($ancestors as $c)
	$this->breadcrumbs[$c->name] = $c->getViewUrl();

$this->breadcrumbs[] = $this->model->name;

//$this->sidebarContent = $this->widget('application.modules.store.widgets.SFilterRenderer', array(
//	'model'=>$model,
//	'attributes'=>$this->categoryAttributes,
//	'criteria'=>$criteria
//), true);

?>

<h3><?php echo CHtml::encode($this->model->name); ?></h3>

<div class="row show-grid">
	<?php
	$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$provider,
		'ajaxUpdate'=>false,
		'template'=>'{sorter} {items} {pager} {summary}',
		'itemView'=>'_product',
		'sortableAttributes'=>array(
			'name', 'price'
		),
	));
	?>
</div>
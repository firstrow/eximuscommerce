<?php
/**
 * Product view
 */

// Set meta tags
$this->pageTitle = ($model->meta_title) ? $model->meta_title : $model->name;
$this->pageKeywords = $model->meta_keywords;
$this->pageDescription = $model->meta_description;

// Create breadcrumbs
$ancestors = $model->mainCategory->excludeRoot()->ancestors()->findAll();

foreach($ancestors as $c)
	$this->breadcrumbs[$c->name] = $c->getViewUrl();

// Do not add root category
if ($model->mainCategory->id != 1)
	$this->breadcrumbs[$model->mainCategory->name] = $model->mainCategory->getViewUrl();

$this->breadcrumbs[] = $model->name;

?>

<h3><?php echo CHtml::encode($model->name); ?></h3>

<div class="row">
	<!-- Left column  -->
	<div class="span4 container">
		<a href="#" class="thumbnail">
			<img src="http://placehold.it/300x230" alt="">
		</a>
	</div>
	<!-- Right column -->
	<div class="span6">
		<p><?php echo $model->short_description; ?></p>
		<p><?php echo $model->full_description; ?></p>

		<h4>Цена: <?php echo $model->price ?></h4>
		<input type="submit" class="btn success" value="Купить">

		<?php if($model->getEavAttributes()): ?>
			<h4>Характеристики</h4>
		<?php endif; ?>
		<?php
			// Display product custom options table.
			$this->widget('application.modules.store.widgets.SAttributesTableRenderer', array(
				'model'=>$model,
				'htmlOptions'=>array('class'=>'table table-bordered table-striped'),
			));
		?>
	</div>
</div>
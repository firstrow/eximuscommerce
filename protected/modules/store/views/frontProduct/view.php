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
	<div class="span3">
		<a href="#" class="thumbnail">
			<img src="http://placehold.it/300x230" alt="">
		</a>
	</div>

	<!-- Right column -->
	<div class="span8">
		<p><?php echo $model->short_description; ?></p>
		<p><?php echo $model->full_description; ?></p>

		<h4>Цена: <?php echo $model->price ?></h4>
        <a href="#" class="btn btn-large btn-primary">Купить</a>

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

        <ul class="tabs nav nav-tabs" id="tab">
            <li class="active"><a href="#home" data-toggle="tab">Home</a></li>
            <li><a href="#profile" data-toggle="tab">Profile</a></li>
            <li><a href="#messages" data-toggle="tab">Messages</a></li>
            <li><a href="#settings" data-toggle="tab">Settings</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="home">1</div>
            <div class="tab-pane" id="profile">2</div>
            <div class="tab-pane" id="messages">..3.</div>
            <div class="tab-pane" id="settings">4</div>
        </div>

        <script>
            $(function () {
                $('#tab').tab();
            })
        </script>
	</div>

</div>

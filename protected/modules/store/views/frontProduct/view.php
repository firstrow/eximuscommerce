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

// Fancybox ext
$this->widget('application.extensions.fancybox.EFancyBox', array(
        'target'=>'a.thumbnail',
        'config'=>array(),
    )
);

?>

<h3><?php echo CHtml::encode($model->name); ?></h3>

<div class="row">
	<!-- Left column  -->
	<div class="span4">
        <ul class="thumbnails">
            <li class="span4">
                <?php
                    if($model->mainImage)
                        $imgSource = $model->mainImage->getUrl('360x268', 'resize');
                    else
                        $imgSource = 'http://placehold.it/300x230';
                    echo CHtml::link(CHtml::image($imgSource), $model->mainImage->getUrl(), array('class'=>'thumbnail'));
                ?>
            </li>
            <?php
                foreach($model->imagesNoMain as $image)
                {
                    echo CHtml::openTag('li', array('class'=>'span2'));
                    echo CHtml::link(CHtml::image($image->getUrl('160x120')), $image->getUrl(), array('class'=>'thumbnail'));
                    echo CHtml::closeTag('li');
                }
            ?>
        </ul>
	</div>

	<!-- Right column -->
	<div class="span6">
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

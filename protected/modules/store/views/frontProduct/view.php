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

// Do not add root category to breadcrumbs
if ($model->mainCategory->id != 1)
	$this->breadcrumbs[$model->mainCategory->name] = $model->mainCategory->getViewUrl();

$this->breadcrumbs[] = $model->name;

// Fancybox ext
$this->widget('application.extensions.fancybox.EFancyBox', array(
    'target'=>'a.thumbnail',
    'config'=>array(),
));

?>

<h3><?php echo CHtml::encode($model->name); ?></h3>

<div class="row">
	<!-- Left column  -->
	<div class="span4">
        <ul class="thumbnails">
            <li class="span4">
                <?php
                    if($model->mainImage)
                        echo CHtml::link(CHtml::image($model->mainImage->getUrl('360x268', 'resize')), $model->mainImage->getUrl(), array('class'=>'thumbnail'));
                    else
                        echo CHtml::link(CHtml::image('http://placehold.it/360x268'), '#', array('class'=>'thumbnail'));
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
	<div class="span7">
		<p><?php echo $model->short_description; ?></p>
		<p><?php echo $model->full_description; ?></p>

		<h4>Цена: <?php echo $model->price ?></h4>
        <a href="#" class="btn btn-large btn-primary">Купить</a>

        <div class="row">&nbsp;</div>

        <?php
            if($model->getEavAttributes())
            {
                // Display product custom options table.
                $this->widget('application.modules.store.widgets.SAttributesTableRenderer', array(
                    'model'=>$model,
                    'htmlOptions'=>array('class'=>'table table-bordered table-striped'),
                ));
            }else
                echo 'Нет характеристик';
        ?>
	</div>

</div>

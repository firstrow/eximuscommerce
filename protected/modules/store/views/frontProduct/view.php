<?php
/**
 * Product view
 * @var StoreProduct $model
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

// Register main script
Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl.'/product.view.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl.'/product.view.configurations.js', CClientScript::POS_END);

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

		<?php
			echo CHtml::form(array('/orders/cart/add'));
		?>
		<div>
			<table class="table table-striped table-bordered table-condensed">
				<?php
					$jsVariantsData = array();

					foreach($model->processVariants() as $variant)
					{
						echo '<tr><td>';
						echo $variant['attribute']->title;
						echo '</td><td>';
						$dropDownData = array('---');
						foreach($variant['options'] as $v)
						{
							$jsVariantsData[$v->id] = $v;
							$dropDownData[$v->id] = $v->option->value;
						}
						echo CHtml::dropDownList('eav['.$variant['attribute']->id.']', null, $dropDownData, array('class'=>'variantData'));
						echo '</td></tr>';
					}

					// Register variant prices script
					Yii::app()->clientScript->registerScript('jsVariantsData','
						var jsVariantsData = '.CJavaScript::jsonEncode($jsVariantsData).';
					', CClientScript::POS_END);

					// Display product configurations
					if($model->use_configurations)
					{
						// Get data
						$confData = $this->getConfigurableData();

						// Register configuration script
						Yii::app()->clientScript->registerScript('productPrices', strtr('
							var productPrices = {prices};
						', array(
							'{prices}'=>CJavaScript::encode($confData['prices'])
						)), CClientScript::POS_END);

						foreach($confData['attributes'] as $attr)
						{
							if(isset($confData['data'][$attr->name]))
							{
								echo '<tr><td>';
								echo $attr->title;
								echo '</td><td>';
								echo CHtml::dropDownList('configurations['.$attr->name.']', null, array_flip($confData['data'][$attr->name]), array('class'=>'eavData'));
								echo '</td></tr>';
							}
						}
					}
				?>
			</table>
		</div>

		<!-- Display errors here -->
		<div class="alert alert-error" id="productErrors" style="display: none;"></div>

		<h4>Цена: <span id="productPrice"><?php echo StoreProduct::formatPrice($model->price); ?></span></h4>
		<br>
		<?php
			echo CHtml::hiddenField('product_id', $model->id);
			echo CHtml::hiddenField('product_price', $model->price);
			echo CHtml::hiddenField('use_configurations', $model->use_configurations);
			echo CHtml::hiddenField('configurable_id', 0);
			echo CHtml::textField('quantity', 1, array('class'=>'span1'));

			echo CHtml::ajaxSubmitButton('Купить', array('/orders/cart/add'), array(
				'dataType'=>'json',
				'success'=>'js:function(data, textStatus, jqXHR){processCartResponse(data, textStatus, jqXHR)}',
			), array('class'=>'btn-primary'));

			echo CHtml::endForm();
		?>

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

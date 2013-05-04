<?php
/**
 * Product view
 * @var StoreProduct $model
 * @var $this Controller
 */

// Set meta tags
$this->pageTitle = ($model->meta_title) ? $model->meta_title : $model->name;
$this->pageKeywords = $model->meta_keywords;
$this->pageDescription = $model->meta_description;

// Register main script
Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl.'/product.view.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl.'/product.view.configurations.js', CClientScript::POS_END);

// Create breadcrumbs
if($model->mainCategory)
{
	$ancestors = $model->mainCategory->excludeRoot()->ancestors()->findAll();

	foreach($ancestors as $c)
		$this->breadcrumbs[$c->name] = $c->getViewUrl();

	// Do not add root category to breadcrumbs
	if ($model->mainCategory->id != 1)
		$this->breadcrumbs[$model->mainCategory->name] = $model->mainCategory->getViewUrl();
}

// Fancybox ext
$this->widget('application.extensions.fancybox.EFancyBox', array(
	'target'=>'a.thumbnail',
));

?>

<div class="product">
	<div class="breadcrumbs">
		<?php
			$this->widget('zii.widgets.CBreadcrumbs', array(
				'links'=>$this->breadcrumbs,
			));
		?>
	</div>

	<div class="images">
		<div class="image_row">
			<div class="main">
				<?php
					// Main product image
					if($model->mainImage)
						echo CHtml::link(CHtml::image($model->mainImage->getUrl('340x250', 'resize'), $model->mainImage->title), $model->mainImage->getUrl(), array('class'=>'thumbnail'));
					else
						echo CHtml::link(CHtml::image('http://placehold.it/340x250'), '#', array('class'=>'thumbnail'));
				?>
			</div>
			<div class="stars">
				<?php $this->widget('CStarRating',array(
					'name'=>'rating_'.$model->id,
					'id'=>'rating_'.$model->id,
					'allowEmpty'=>false,
					'readOnly'=>isset(Yii::app()->request->cookies['rating_'.$model->id]),
					'minRating'=>1,
					'maxRating'=>5,
					'value'=>($model->rating+$model->votes) ? round($model->rating / $model->votes) : 0,
					'callback'=>'js:function(){rateProduct('.$model->id.')}',
			)); ?>
			</div>
		</div>
		<div class="additional">
			<ul>
			<?php
			// Display additional images
			foreach($model->imagesNoMain as $image)
			{
				echo CHtml::openTag('li', array('class'=>'span2'));
				echo CHtml::link(CHtml::image($image->getUrl('160x120'), $image->title), $image->getUrl(), array('class'=>'thumbnail'));
				echo CHtml::closeTag('li');
			}
			?>
			</ul>
		</div>
	</div>

	<div class="info">
		<?php echo CHtml::form(array('/orders/cart/add')) ?>

		<h1><?php echo CHtml::encode($model->name); ?></h1>

		<?php $this->renderPartial('_configurations', array('model'=>$model)); ?>

		<div class="errors" id="productErrors"></div>

		<div style="clear: both;font-size: 16px">
			<?php
			if($model->appliedDiscount)
				echo '<span style="color:red; "><s>'.$model->toCurrentCurrency('originalPrice').' '.Yii::app()->currency->active->symbol.'</s></span>';
			?>
		</div>

		<div class="price">
			<span id="productPrice"><?php echo StoreProduct::formatPrice($model->toCurrentCurrency()); ?></span>
			<?php echo Yii::app()->currency->active->symbol; ?>
		</div>

		<div class="actions">
			<?php
				echo CHtml::hiddenField('product_id', $model->id);
				echo CHtml::hiddenField('product_price', $model->price);
				echo CHtml::hiddenField('use_configurations', $model->use_configurations);
				echo CHtml::hiddenField('currency_rate', Yii::app()->currency->active->rate);
				echo CHtml::hiddenField('configurable_id', 0);
				echo CHtml::hiddenField('quantity', 1);

				if($model->isAvailable)
				{
					echo CHtml::ajaxSubmitButton(Yii::t('StoreModule.core','Купить'), array('/orders/cart/add'), array(
						'dataType' => 'json',
						'success'  => 'js:function(data, textStatus, jqXHR){processCartResponse(data, textStatus, jqXHR)}',
					), array(
						'id'=>'buyButton',
						'class'=>'blue_button'
					));
				}
				else
				{
					echo CHtml::link('Сообщить о появлении', '#', array(
						'onclick' => 'showNotifierPopup('.$model->id.'); return false;',
					));
				}

				echo CHtml::endForm();
			?>

			<div class="silver_clean silver_button">
				<button title="<?=Yii::t('core','Сравнить')?>" onclick="return addProductToCompare(<?php echo $model->id ?>);"><span class="icon compare"></span>Сравнить</button>
			</div>

			<div class="silver_clean silver_button">
				<button title="<?=Yii::t('core','В список желаний')?>" onclick="return addProductToWishList(<?php echo $model->id ?>);"><span class="icon heart"></span>Список желаний</button>
			</div>
		</div>
		<div class="desc"><?php echo $model->short_description; ?></div>
		<div class="desc"><?php echo $model->full_description; ?></div>
	</div>

	<div style="clear:both;"></div>

	<?php
		$tabs = array();

		// EAV tab
		if($model->getEavAttributes())
		{
			$tabs[Yii::t('StoreModule.core', 'Характеристики')] = array(
				'content'=>$this->renderPartial('_attributes', array('model'=>$model), true
			));
		}

		// Comments tab
		$tabs[Yii::t('StoreModule.core', 'Отзывы').' ('.$model->commentsCount.')'] = array(
			'id'=>'comments_tab',
			'content'=>$this->renderPartial('comments.views.comment.create', array(
				'model'=>$model,
			), true));

		// Related products tab
		if($model->relatedProductCount)
		{
			$tabs[Yii::t('StoreModule.core', 'Сопутствующие продукты').' ('.$model->relatedProductCount.')'] = array(
				'id'=>'related_products_tab',
				'content'=>$this->renderPartial('_related', array(
					'model'=>$model,
				), true));
		}

		// Render tabs
		$this->widget('zii.widgets.jui.CJuiTabs', array(
			'id'=>'tabs',
			'tabs'=>$tabs
		));

		// Fix tabs opening by anchor
		Yii::app()->clientScript->registerScript('tabSelector', '
			$(function() {
				var anchor = $(document).attr("location").hash;
				var result = $("#tabs").find(anchor).parents(".ui-tabs-panel");
				if($(result).length)
				{
					$("#tabs").tabs("select", "#"+$(result).attr("id"));
				}
			});
		');
	?>
</div>

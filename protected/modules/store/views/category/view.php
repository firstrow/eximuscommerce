<?php

/**
 * Category view
 * @var $this CategoryController
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

?>

<div class="catalog_with_sidebar">
	<div id="filter">
		<?php
			$this->widget('application.modules.store.widgets.filter.SFilterRenderer', array(
				'model'=>$this->model,
				'attributes'=>$this->eavAttributes,
			));
		?>
	</div>

	<div class="products_list <?php if($itemView==='_product_wide') echo 'wide'; ?>">
		<div class="breadcrumbs">
			<?php
				$this->widget('zii.widgets.CBreadcrumbs', array(
					'links'=>$this->breadcrumbs,
				));
			?>
		</div>

		<h1><?php echo CHtml::encode($this->model->name); ?></h1>

		<?php if(!empty($this->model->description)): ?>
			<div>
				<?php echo $this->model->description ?>
			</div>
		<?php endif ?>

		<div class="actions">
			<?php
				echo Yii::t('StoreModule.core', 'Сортировать:');
				echo CHtml::dropDownList('sorter', Yii::app()->request->url, array(
					Yii::app()->request->removeUrlParam('/store/category/view', 'sort')  => '---',
					Yii::app()->request->addUrlParam('/store/category/view', array('sort'=>'price'))  => Yii::t('StoreModule.core', 'Сначала дешевые'),
					Yii::app()->request->addUrlParam('/store/category/view', array('sort'=>'price.desc')) => Yii::t('StoreModule.core', 'Сначала дорогие'),
				), array('onchange'=>'applyCategorySorter(this)'));
			?>

			<?php
				$limits=array(Yii::app()->request->removeUrlParam('/store/category/view', 'per_page')  => $this->allowedPageLimit[0]);
				array_shift($this->allowedPageLimit);
				foreach($this->allowedPageLimit as $l)
					$limits[Yii::app()->request->addUrlParam('/store/category/view', array('per_page'=> $l))]=$l;

				echo Yii::t('StoreModule.core', 'На странице:');
				echo CHtml::dropDownList('per_page', Yii::app()->request->url, $limits, array('onchange'=>'applyCategorySorter(this)'));
			?>

			<div class="buttons">
				<div class="silver_clean silver_button <?php if($itemView==='_product_wide') echo 'active'; ?>">
					<a <?php if($itemView==='_product_wide') echo 'class="active"'; ?> href="<?php echo Yii::app()->request->addUrlParam('/store/category/view',  array('view'=>'wide')) ?>"><span class="icon lines"></span>Списком</a>
				</div>
				<div class="silver_clean silver_button <?php if($itemView==='_product') echo 'active'; ?>">
					<a <?php if($itemView==='_product') echo 'class="active"'; ?> href="<?php echo Yii::app()->request->removeUrlParam('/store/category/view', 'view') ?>"><span class="icon dots"></span>Картинками</a>
				</div>
			</div>
		</div>

		<?php
			$this->widget('zii.widgets.CListView', array(
				'dataProvider'=>$provider,
				'ajaxUpdate'=>false,
				'template'=>'{items} {pager} {summary}',
				'itemView'=>$itemView,
				'sortableAttributes'=>array(
					'name', 'price'
				),
			));
		?>
	</div>
</div><!-- catalog_with_sidebar end -->

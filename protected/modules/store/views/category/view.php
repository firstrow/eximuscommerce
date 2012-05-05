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

	<div class="products_list">
		<div class="breadcrumbs">
			<?php
			$this->widget('zii.widgets.CBreadcrumbs', array(
				'links'=>$this->breadcrumbs,
			));
			?>
		</div>

		<h1><?php echo CHtml::encode($this->model->name); ?></h1>

		<div class="actions">
			Сортировать:
			<select>
				<option value="">Сначала дешовые</option>
				<option value="">Сначала догорие</option>
				<option value="">По рейтингу</option>
			</select>

			На странице:
			<select>
				<option value="">12</option>
				<option value="">15</option>
				<option value="">18</option>
			</select>

			<div class="silver_clean silver_button">
				<button><span class="icon lines"></span>Списком</button>
			</div>

			<div class="silver_clean silver_button">
				<button><span class="icon dots"></span>Картинками</button>
			</div>
		</div>

		<?php
			$this->widget('zii.widgets.CListView', array(
				'dataProvider'=>$provider,
				'ajaxUpdate'=>false,
				'template'=>'{items} {pager} {summary}',
				'itemView'=>'_product',
				'sortableAttributes'=>array(
					'name', 'price'
				),
			));
		?>
	</div>
</div><!-- catalog_with_sidebar end -->

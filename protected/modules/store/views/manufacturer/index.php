<?php

/**
 * Manufacturer
 * @var $model StoreManufacturer
 */

// Set meta tags
$this->pageTitle = ($this->model->meta_title) ? $this->model->meta_title : $this->model->name;
$this->pageKeywords = $this->model->meta_keywords;
$this->pageDescription = $this->model->meta_description;

?>

<div>
	<div class="products_list">
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
				Yii::app()->request->removeUrlParam('/store/manufacturer/index', 'sort')  => '---',
				Yii::app()->request->addUrlParam('/store/manufacturer/index', array('sort'=>'price'))  => Yii::t('StoreModule.core', 'Сначала дешевые'),
				Yii::app()->request->addUrlParam('/store/manufacturer/index', array('sort'=>'price.desc')) => Yii::t('StoreModule.core', 'Сначала дорогие'),
			), array('onchange'=>'applyCategorySorter(this)'));
			?>

			<?php
			$limits=array(Yii::app()->request->removeUrlParam('/store/manufacturer/index', 'per_page')  => $this->allowedPageLimit[0]);
			array_shift($this->allowedPageLimit);
			foreach($this->allowedPageLimit as $l)
				$limits[Yii::app()->request->addUrlParam('/store/manufacturer/index', array('per_page'=> $l))]=$l;

			echo Yii::t('StoreModule.core', 'На странице:');
			echo CHtml::dropDownList('per_page', Yii::app()->request->url, $limits, array('onchange'=>'applyCategorySorter(this)'));
			?>
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

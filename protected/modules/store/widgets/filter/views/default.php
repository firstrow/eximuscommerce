<?php

/**
 * @var $this SFilterRenderer
 */

/**
 * Render filters based on the next array:
 * $data[attributeName] = array(
 *	    'title'=>'Filter Title',
 *	    'selectMany'=>true, // Can user select many filter options
 *	    'filters'=>array(array(
 *	        'title'      => 'Title',
 *	        'count'      => 'Products count',
 *	        'queryKey'   => '$_GET param',
 *	        'queryParam' => 'many',
 *	    ))
 *  );
 */

// Render active filters
$active = $this->getActiveFilters();
if(!empty($active))
{
	echo CHtml::openTag('div', array('class'=>'rounded'));
		echo CHtml::openTag('div', array('class'=>'filter_header'));
		echo Yii::t('StoreModule.core', 'Текущие фильтры');
		echo CHtml::closeTag('div');

		$this->widget('zii.widgets.CMenu', array(
			'htmlOptions'=>$this->activeFiltersHtmlOptions,
			'items'=>$active
		));

		echo CHtml::link(Yii::t('StoreModule.core','Сбросить фильтр'), $this->getOwner()->createUrl('view', array('url'=>$this->model->url)), array('class'=>'cancel_filter'));
	echo CHtml::closeTag('div');
}
?>

<div class="rounded price_slider">
	<div class="filter_header">
		<?php echo Yii::t('StoreModule.core', 'Цена') ?>
	</div>
<?php
	$cm=Yii::app()->currency;
	echo $this->widget('zii.widgets.jui.CJuiSlider', array(
		'options'=>array(
			'range'=>true,
			'min'=>(int)floor($cm->convert($this->controller->getMinPrice())),
			'max'=>(int)ceil($cm->convert($this->controller->getMaxPrice())),
			'disabled'=>(int)$this->controller->getMinPrice()===(int)$this->controller->getMaxPrice(),
			'values'=>array($this->currentMinPrice, $this->currentMaxPrice),
			'slide'=>'js: function( event, ui ) {
				$("#min_price").val(ui.values[0]);
				$("#max_price").val(ui.values[1]);
			}',
		),
		'htmlOptions'=>array(
			'style'=>'margin:5px',
		),
	), true);
?>
<?php echo CHtml::form() ?>
	от <?php echo CHtml::textField('min_price', (isset($_GET['min_price'])) ? (int)$this->getCurrentMinPrice():null ) ?>
	до <?php echo CHtml::textField('max_price', (isset($_GET['max_price'])) ? (int)$this->getCurrentMaxPrice():null ) ?>
	<?php echo Yii::app()->currency->active->symbol ?>
	<button class="small_silver_button" type="submit">OK</button>
<?php echo CHtml::endForm() ?>
</div>

<?php
if(!empty($manufacturers['filters']) || !empty($attributes))
	echo CHtml::openTag('div', array('class'=>'rounded'));

	// Render manufacturers
	if(!empty($manufacturers['filters']))
	{
		echo CHtml::openTag('div', array('class'=>'filter_header'));
		echo CHtml::encode(Yii::t('StoreModule.core', 'Производитель'));
		echo CHtml::closeTag('div');

		echo CHtml::openTag('ul', array('class'=>'filter_links'));
		foreach($manufacturers['filters'] as $filter)
		{
			$url = Yii::app()->request->addUrlParam('/store/category/view', array($filter['queryKey'] => $filter['queryParam']), $manufacturers['selectMany']);
			$queryData = explode(';', Yii::app()->request->getQuery($filter['queryKey']));

			echo CHtml::openTag('li');
			// Filter link was selected.
			if(in_array($filter['queryParam'], $queryData))
			{
				// Create link to clear current filter
				$url = Yii::app()->request->removeUrlParam('/store/category/view', $filter['queryKey'], $filter['queryParam']);
				echo CHtml::link($filter['title'], $url, array('style'=>'color:green'));
			}
			elseif($filter['count'] > 0)
				echo CHtml::link($filter['title'], $url).' ('.$filter['count'].')';
			else
				echo $filter['title'].' (0)';

			echo CHtml::closeTag('li');
		}
		echo CHtml::closeTag('ul');
	}

	// Display attributes
	foreach($attributes as $attrData)
	{
		echo CHtml::openTag('div', array('class'=>'filter_header'));
		echo CHtml::encode($attrData['title']);
		echo CHtml::closeTag('div');

		echo CHtml::openTag('ul', array('class'=>'filter_links'));
		foreach($attrData['filters'] as $filter)
		{
			$url = Yii::app()->request->addUrlParam('/store/category/view', array($filter['queryKey'] => $filter['queryParam']), $attrData['selectMany']);
			$queryData = explode(';', Yii::app()->request->getQuery($filter['queryKey']));

			echo CHtml::openTag('li');
			// Filter link was selected.
			if(in_array($filter['queryParam'], $queryData))
			{
				// Create link to clear current filter
				$url = Yii::app()->request->removeUrlParam('/store/category/view', $filter['queryKey'], $filter['queryParam']);
				echo CHtml::link($filter['title'], $url, array('style'=>'color:green'));
			}
			elseif($filter['count'] > 0)
				echo CHtml::link($filter['title'], $url).' ('.$filter['count'].')';
			else
				echo $filter['title'].' (0)';

			echo CHtml::closeTag('li');
		}
		echo CHtml::closeTag('ul');
	}

if(!empty($manufacturers['filters']) || !empty($attributes))
	echo CHtml::closeTag('div');
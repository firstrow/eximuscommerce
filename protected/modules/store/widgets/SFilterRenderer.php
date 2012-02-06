<?php

/**
 * Base class to render filters by:
 *  Manufacturer
 *  Price
 *  Eav attributes
 *
 * Usage:
 * $this->widget('application.modules.store.widgets.SFilterRenderer', array(
 *      // StoreCategory model. Used to create url
 *      'model'=>$model,
 *  ));
 *
 * @method CategoryController getOwner()
 */
class SFilterRenderer extends CWidget
{

	/**
	 * @var array of StoreAttribute models
	 */
	public $attributes;

	/**
	 * @var StoreCategory
	 */
	public $model;

	/**
	 * @var string Tag to surround attribute set title.
	 */
	public $titleTag = 'h5';

	/**
	 * @var array of option to apply to filter html ul list
	 */
	public $htmlOptions = array();

	/**
	 * @var array html option to apply to `Clear attributes` link
	 */
	public $clearLinkOptions = array('class'=>'clearOptions');

	/**
	 * @var array of options to apply to 'active filters' menu
	 */
	public $activeFiltersHtmlOptions = array();

	/**
	 * Render filters
	 */
	public function run()
	{
		// Render active filters
		$this->renderActiveFilters();
		// Render manufacturers
		$this->renderData($this->getCategoryManufacturers());
		// Render eav attributes
		foreach($this->getCategoryAttributes() as $attrData)
			$this->renderData($attrData);
	}

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
	 * @param $data
	 */
	public function renderData($data)
	{
		// Render title
		if(isset($data['title']))
		{
			echo CHtml::openTag($this->titleTag);
			echo CHtml::encode($data['title']);
			echo CHtml::closeTag($this->titleTag);
		}

		echo CHtml::openTag('ul', $this->htmlOptions);
		foreach($data['filters'] as $filter)
		{
			$url = $this->addUrlParam(array($filter['queryKey'] => $filter['queryParam']), $data['selectMany']);
			$queryData = explode(';', Yii::app()->request->getQuery($filter['queryKey']));
			$filter = CHtml::encodeArray($filter);

			echo CHtml::openTag('li');
			// Filter link was selected.
			if(in_array($filter['queryParam'], $queryData))
			{
				// Create link to clear current filter
				$url = $this->removeUrlParam($filter['queryKey'], $filter['queryParam']);
				echo CHtml::link($filter['title'], $url, array('style'=>'color:green'));
			}
			elseif($filter['count'] > 0)
				echo CHtml::link($filter['title'], $url).' ('.$filter['count'].')';
			else
				echo Chtml::encode($filter['title']).' (0)';

			echo CHtml::closeTag('li');
		}
		echo CHtml::closeTag('ul');
	}

	/**
	 * Render active/applied filters to make easier to cancel them.
	 */
	public function renderActiveFilters()
	{
		// Render links to cancel applied filters.
		// Render link to cancel filter by manufacturer.
		$menuItems = array();
		$manufacturers = array_filter(explode(';', Yii::app()->request->getQuery('manufacturer')));
		$manufacturers = StoreManufacturer::model()->findAllByPk($manufacturers);

		if(!empty($manufacturers))
		{
			foreach($manufacturers as $manufacturer)
			{
				array_push($menuItems, array(
					'label'=> $manufacturer->name,
					'url'  => $this->removeUrlParam('manufacturer', $manufacturer->id)
				));
			}
		}

		// Render eav attributes
		$activeAttributes = $this->getOwner()->activeAttributes;
		if(!empty($activeAttributes))
		{
			foreach($activeAttributes as $attributeName=>$value)
			{
				if(isset($this->getOwner()->eavAttributes[$attributeName]))
				{
					$attribute = $this->getOwner()->eavAttributes[$attributeName];
					foreach($attribute->options as $option)
					{
						if(isset($activeAttributes[$attribute->name]) && in_array($option->id, $activeAttributes[$attribute->name]))
						{
							array_push($menuItems, array(
								'label'=> CHtml::encode($option->value),
								'url'  => $this->removeUrlParam($attribute->name, $option->id)
							));
						}
					}
				}
			}
		}

		// Render
		if(!empty($menuItems))
		{
			echo CHtml::openTag($this->titleTag);
			echo Yii::t('StoreModule.core', 'Текущие фильтры');
			echo CHtml::closeTag($this->titleTag);

			array_push($menuItems, array(
				'label'=>Yii::t('StoreModule.core', 'Очистить фильтры'),
				'url'=>$this->getOwner()->createUrl('view', array('url'=>$this->model->url)),
				'linkOptions'=>$this->clearLinkOptions,
			));

			$this->widget('zii.widgets.CMenu', array(
				'htmlOptions'=>$this->activeFiltersHtmlOptions,
				'items'=>$menuItems
			));
		}
	}

	/**
	 * @return array of attributes used in category
	 */
	public function getCategoryAttributes()
	{
		$data = array();

		foreach($this->attributes as $attribute)
		{
			$data[$attribute->name] = array(
				'title'      => $attribute->title,
				'selectMany' => (boolean) $attribute->select_many,
				'filters'    => array()
			);
			foreach($attribute->options as $option)
			{
				$data[$attribute->name]['filters'][] = array(
					'title'      => $option->value,
					'count'      => $this->countAttributeProducts($attribute, $option),
					'queryKey'   => $attribute->name,
					'queryParam' => $option->id,
				);
			}
		}
		return $data;
	}

	/**
	 * Count products by attribute and option
	 * @param StoreAttribute $attribute
	 * @param string $option option id to search
	 * @todo Optimize attributes merging
	 * @return string
	 */
	public function countAttributeProducts($attribute, $option)
	{
		$model = new StoreProduct(null);
		$model->attachBehaviors($model->behaviors());
		$model->active()->applyCategories($this->model);

		if(Yii::app()->request->getParam('manufacturer'))
			$model->applyManufacturers(explode(';', Yii::app()->request->getParam('manufacturer')));

		$data = array($attribute->name=>$option->id);
		$current = $this->getOwner()->activeAttributes;

		$newData = array();

		foreach($current as $key=>$row)
		{
			if(!isset($newData[$key])) $newData[$key] = array();
			if(is_array($row))
			{
				foreach($row as $v)
					$newData[$key][] = $v;
			}
			else
				$newData[$key][] = $row;
		}

		$newData[$attribute->name][] = $option->id;
		return $model->withEavAttributes($newData)->count();
	}

	/**
	 * @return array of category manufacturers
	 */
	public function getCategoryManufacturers()
	{
		$manufacturers = StoreManufacturer::model()
			->orderByName()
			->findAll(array('with'=>array(
			'productsCount'=>array(
				'scopes'=>array(
					'active',
					'applyCategories'=>array($this->model, null),
					'applyAttributes'=>array($this->getOwner()->activeAttributes)
				),
			)
			)));

		$data = array(
			'title'=>Yii::t('StoreModule.core', 'Производитель'),
			'selectMany'=>true,
			'filters'=>array()
		);
		foreach($manufacturers as $m)
		{
			$data['filters'][] = array(
				'title'      => $m->name,
				'count'      => $m->productsCount,
				'queryKey'   => 'manufacturer',
				'queryParam' => $m->id,
			);
		}

		return $data;
	}

	/**
	 * Add param to current url. Url is based on $data and $_GET arrays
	 * @param $data array of the data to add to the url.
	 * @param $selectMany
	 * @return string
	 */
	public function addUrlParam($data, $selectMany=false)
	{
		foreach($data as $key=>$val)
		{
			if(isset($_GET[$key]) && $key !== 'url' && $selectMany === true)
			{
				$tempData = explode(';', $_GET[$key]);
				$data[$key] = implode(';', array_unique(array_merge((array)$data[$key], $tempData)));
			}
		}

		return Yii::app()->createUrl('/store/category/view', CMap::mergeArray($_GET, $data));
	}

	/**
	 * Delete param/value from current
	 * @param string $key to remove from query
	 * @param null $value If not value - delete whole key
	 * @return string new url
	 */
	public function removeUrlParam($key, $value=null)
	{
		$get = $_GET;
		if(isset($get[$key]))
		{
			if($value === null)
				unset($get[$key]);
			else
			{
				$get[$key] = explode(';', $get[$key]);
				$pos = array_search($value, $get[$key]);
				// Delete value
				if(isset($get[$key][$pos]))
					unset($get[$key][$pos]);
				// Save changes
				if(!empty($get[$key]))
					$get[$key] = implode(';', $get[$key]);
				// Delete key if empty
				else
					unset($get[$key]);
			}
		}
		return Yii::app()->createUrl('/store/category/view', $get);
	}
}

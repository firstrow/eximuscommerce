<?php

/**
 * Base class to render attributes in sidebar to filter products.
 * Usage:
 * $this->widget('application.modules.store.widgets.SFilterRenderer', array(
 *      // StoreCategory model. Used to create url
 *      'model'=>$model,
 *  ));
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
	 * Render filters
	 */
	public function run()
	{
		$this->renderData($this->getCategoryManufacturers());
		foreach($this->getCategoryAttributes() as $attrData)
			$this->renderData($attrData);
	}

	public function renderData($data)
	{
		// Render title
		if(isset($data['title']))
		{
			echo CHtml::openTag($this->titleTag);
			echo CHtml::encode($data['title']);
			echo CHtml::closeTag($this->titleTag);
		}

		echo CHtml::openTag('ul');
		foreach($data['filters'] as $filter)
		{
			$url = $this->addUrlParam(array($filter['queryKey'] => $filter['queryParam']), $data['selectMany']);
			$queryData = explode(';', Yii::app()->request->getQuery($filter['queryKey']));

			echo CHtml::openTag('li');
			// Filter link was selected.
			if(in_array($filter['queryParam'], $queryData))
			{
				// Create link to clear current filter
				$url = $this->removeUrlParam($filter['queryKey'], $filter['queryParam']);
				echo CHtml::link($filter['title'], $url, array('style'=>'color:green'));
			}
			elseif($filter['count'] > 0)
				echo CHtml::link($filter['title'], $url).'('.$filter['count'].')';
			else
				echo Chtml::encode($filter['title']).'(0)';

			echo CHtml::closeTag('li');
		}
		echo CHtml::closeTag('ul');
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
				'title'=>$attribute->title,
				'selectMany'=>true,
				'filters'=>array()
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
	 * @param $attribute
	 * @param $option
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

		return $model->withEavAttributes(array_merge($current,$data))->count();
	}

	/**
	 * @return array of category manufacturers
	 */
	public function getCategoryManufacturers()
	{
		$manufacturers = StoreManufacturer::model()
			->findAll(array('with'=>array(
			'productsCount'=>array(
				'scopes'=>array(
					'active',
					'applyCategories'=>array($this->model, null),
					'applyAttributes'=>array($this->getOwner()->activeAttributes)
				),
			),
			)));

		$data = array(
			'title'=>'Manufacturers',
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

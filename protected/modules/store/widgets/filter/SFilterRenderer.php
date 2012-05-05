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
	 * @var array html option to apply to `Clear attributes` link
	 */
	public $clearLinkOptions = array('class'=>'clearOptions');

	/**
	 * @var array of options to apply to 'active filters' menu
	 */
	public $activeFiltersHtmlOptions = array('class'=>'filter_links current');

	public $view = 'default';

	/**
	 * Render filters
	 */
	public function run()
	{
		$this->render($this->view, array(
			'manufacturers'=>$this->getCategoryManufacturers(),
			'attributes'=>$this->getCategoryAttributes(),
		));
	}

	/**
	 * Get active/applied filters to make easier to cancel them.
	 */
	public function getActiveFilters()
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
					'url'  => Yii::app()->request->removeUrlParam('/store/category/view', 'manufacturer', $manufacturer->id)
				));
			}
		}

		// Process eav attributes
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
								'url'  => Yii::app()->request->removeUrlParam('/store/category/view', $attribute->name, $option->id)
							));
						}
					}
				}
			}
		}

		return $menuItems;
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
//		$manufacturers = StoreManufacturer::model()
//			->orderByName()
//			->findAll(array('with'=>array(
//			'productsCount'=>array(
//				'scopes'=>array(
//					'active',
//					'applyCategories'=>array($this->model, null),
//					'applyAttributes'=>array($this->getOwner()->activeAttributes)
//				),
//			)
//			)));

		$cr = new CDbCriteria;
		$cr->select = 't.manufacturer_id, t.id';
		$cr->group = 't.manufacturer_id';
		$cr->addCondition('t.manufacturer_id IS NOT NULL');

		//@todo: Fix manufacturer translation
		$manufacturers = StoreProduct::model()
			->active()
			->applyCategories($this->model, null)
			->with(array(
				'manufacturer'=>array(
					'with'=>array(
						'productsCount'=>array(
							'scopes'=>array(
								'active',
								'applyCategories'=>array($this->model, null),
								'applyAttributes'=>array($this->getOwner()->activeAttributes),
							))
					),
				)))
			->findAll($cr);

		$data = array(
			'title'=>Yii::t('StoreModule.core', 'Производитель'),
			'selectMany'=>true,
			'filters'=>array()
		);

		if($manufacturers)
		{
			foreach($manufacturers as $m)
			{
				$m = $m->manufacturer;
				if($m)
				{
					$data['filters'][] = array(
						'title'      => $m->name,
						'count'      => $m->productsCount,
						'queryKey'   => 'manufacturer',
						'queryParam' => $m->id,
					);
				}
			}
		}

		return $data;
	}

}

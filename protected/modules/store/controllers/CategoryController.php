<?php

/**
 * Display category products
 * TODO: Add default sorting by rating, etc...
 */
class CategoryController extends Controller
{

	/**
	 * @var StoreProduct
	 */
	public $query;

	public $categoryAttributes;
	public $categoryManufacturers;

	/**
	 * Display products list
	 * @param string $url category url
	 */
	public function actionView($url)
	{
		$model = $this->_loadModel($url);
		$this->query = StoreProduct::model();

		$criteria = new CDbCriteria;
		$criteria->select = 't.*';
		$criteria->join = 'LEFT OUTER JOIN `StoreProductCategoryRef` `categorization` ON (`categorization`.`product`=`t`.`id`)';
		$criteria->condition = 'categorization.category='.$model->id;

		// List of attributes available in category
		$this->categoryAttributes = $this->getCategoryAttributes($criteria);

		// List of manufacturers available in category
		$this->categoryManufacturers = $this->getCategoryManufacturers($criteria);

		// Apply EAV attributes from $_GET
		$this->applyEAVCriteria($this->categoryAttributes);

		$provider = new CActiveDataProvider($this->query, array(
			// Set id to false to not display model name in
			// sort and page params
			'id'=>false,
			'criteria'=>$criteria,
			'pagination'=>array(
				// TODO: Apply from settings
				'pageSize'=>20,
			)
		));

		$view = $this->setDesign($model, 'view');
		$this->render($view, array(
			'provider'=>$provider,
			'model'=>$model,
		));
	}

	/**
	 * Load category by url
	 * @param $url
	 * @return StoreCategory
	 * @throws CHttpException
	 */
	public function _loadModel($url)
	{
		// Find category
		$model = StoreCategory::model()
			->withUrl($url)
			->find();

		if (!$model) throw new CHttpException(404, Yii::t('StoreModule.core', 'Категория не найдена.'));

		return $model;
	}

	/**
	 * Find attributes based on products criteria.
	 * Mostly used to display attrs in sidebar to filter product.
	 * @param CDbCriteria|StoreProduct $criteria to find product types
	 * @return array
	 */
	private function getCategoryAttributes($criteria)
	{
		// Find category types
		$criteria = clone $criteria;
		$builder = new CDbCommandBuilder(Yii::app()->db->getSchema());
		$criteria->select = 'type_id';
		$criteria->group = 'type_id';
		$criteria->distinct = true;
		$typesUsed = $builder->createFindCommand(StoreProduct::tableName(), $criteria)->queryColumn();

		if(empty($typesUsed))
			return array();

		$types = array();
		foreach($typesUsed as $key)
			array_push($types, $key);

		// Find attributes by type
		$criteria = new CDbCriteria;
		$criteria->addInCondition('types.type_id', $types);
		return StoreAttribute::model()
			->useInFilter()
			->with(array('types'))
			->findAll($criteria);
	}

	/**
	 *
	 * @param CDbCriteria $criteria
	 * @return array
	 */
	private function getCategoryManufacturers($criteria)
	{
		$criteria = clone $criteria;
		$builder = new CDbCommandBuilder(Yii::app()->db->getSchema());

		$criteria->select = 'manufacturer_id';
		$criteria->group = 'manufacturer_id';
		$criteria->distinct = true;
		$manufacturers = $builder->createFindCommand(StoreProduct::tableName(), $criteria)->queryColumn();

		return StoreManufacturer::model()->findAllByPk($manufacturers);
	}

	/**
	 * Use EAV in product search query
	 * @param array $attributes list of allowed attribute models
	 */
	private function applyEAVCriteria($attributes)
	{
		if(empty($attributes))
			return;

		$data = array();
		foreach($attributes as $attr)
		{
			if(isset($_GET[$attr->name]))
				$data[$attr->name]=$_GET[$attr->name];
		}
		$this->query->withEavAttributes($data);
	}
}

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

	/**
	 * Display products list
	 * @param string $url category url
	 */
	public function actionView($url)
	{
		$model = $this->_loadModel($url);
		$this->query = StoreProduct::model()
			->with(array(
				'categorization'=>array(
					'condition'=>'categorization.category=:c',
					'params'=>array(':c'=>$model->id),
					'together'=>true,
				),
			));

		$criteria = $this->query->getDbCriteria();

		// List of attributes available in category
		$usedAttributes = StoreProduct::getAttributesByCriteria($criteria);

		// Apply EAV attributes from $_GET
		$this->applyEAVCriteria($usedAttributes);

		$provider = new CActiveDataProvider('StoreProduct', array(
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
			'usedAttributes'=>$usedAttributes
		));
	}

	/**
	 * Load category by url
	 * @param $url
	 * @return CActiveRecord
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
	 * Use EAV in product search query
	 * @param $usedAttributes list of allowed attribute models
	 */
	private function applyEAVCriteria($usedAttributes)
	{
		if(empty($usedAttributes))
			return;

		foreach($usedAttributes as $attr)
		{
			if(isset($_GET[$attr->name]))
				$this->query->withEavAttributes(array($attr->name=>$_GET[$attr->name]));
		}
	}
}

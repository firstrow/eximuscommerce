<?php

/**
 * Display product view page.
 */
class FrontProductController extends Controller
{

	/**
	 * @var StoreProduct
	 */
	public $model;

	/**
	 * @return array
	 */
	public function actions()
	{
		return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
			),
		);
	}

	/**
	 * Display product
	 * @param string $url product url
	 */
	public function actionView($url)
	{
		$this->_loadModel($url);
		$view = $this->setDesign($this->model, 'view');

		$this->render($view, array(
			'model' => $this->model,
		));
	}

	/**
	 * Load StoreProduct model by url
	 * @param $url
	 * @return StoreProduct
	 * @throws CHttpException
	 */
	protected function _loadModel($url)
	{
		$this->model = StoreProduct::model()
			->active()
			->withUrl($url)
			->find();

		if (!$this->model)
			throw new CHttpException(404, Yii::t('StoreModule.core', 'Продукт не найден.'));

		$this->model->saveCounters(array('views_count'=>1));
		return $this->model;
	}


	/**
	 * Get data to render dropdowns for configurable product.
	 * Used on product view.
	 * array(
	 *      'attributes' // Array of StoreAttribute models used for configurations
	 *      'prices'     // Key/value array with configurations prices array(product_id=>price)
	 *      'data'       // Array to render dropdowns. array(color=>array('Green'=>'1/3/5/', 'Silver'=>'7/'))
	 * )
	 * @todo Optimize. Cache queries.
	 * @return array
	 */
	public function getConfigurableData()
	{
		$attributeModels = StoreAttribute::model()->findAllByPk($this->model->configurable_attributes);
		$models = StoreProduct::model()->findAllByPk($this->model->configurations);

		$data = array();
		$prices = array();
		foreach($attributeModels as $attr)
		{
			foreach($models as $m)
			{
				$prices[$m->id] = $m->price;
				if(!isset($data[$attr->name]))
					$data[$attr->name] = array('---'=>'0');

				$method = 'eav_'.$attr->name;
				$value = $m->$method;

				if(!isset($data[$attr->name][$value]))
					$data[$attr->name][$value] = '';

				$data[$attr->name][$value] .= $m->id.'/';
			}
		}

		return array(
			'attributes'=>$attributeModels,
			'prices'=>$prices,
			'data'=>$data,
		);
	}
}
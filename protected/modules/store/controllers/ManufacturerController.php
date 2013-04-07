<?php

class ManufacturerController extends Controller
{
	/**
	 * @var StoreManufacturer
	 */
	public $model;

	/**
	 * @var array
	 */
	public $allowedPageLimit;

	/**
	 * Sets page limits
	 *
	 * @return bool
	 */
	public function beforeAction($action)
	{
		$this->allowedPageLimit=explode(',',Yii::app()->settings->get('core', 'productsPerPage'));
		return true;
	}

	/**
	 * Display products by manufacturer
	 *
	 * @param $url
	 * @throws CHttpException
	 */
	public function actionIndex($url)
	{
		$this->model = StoreManufacturer::model()->findByAttributes(array('url'=>$url));

		if (!$this->model)
			throw new CHttpException(404, Yii::t('StoreModule.core', 'Производитель не найден.'));


		$query = new StoreProduct(null);
		$query->attachBehaviors($query->behaviors());
		$query->active();
		$query->applyManufacturers($this->model->id);

		$provider = new CActiveDataProvider($query, array(
			'id'=>false,
			'pagination'=>array(
				'pageSize'=>$this->allowedPageLimit[0],
			)
		));

		$this->render('index', array(
			'provider'=>$provider,
		));
	}
}

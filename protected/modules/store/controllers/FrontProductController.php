<?php

/**
 * Display products
 */
class FrontProductController extends Controller
{

	/**
	 * Display product
	 * @param string $url product url
	 */
	public function actionView($url)
	{
		$model = StoreProduct::model()
			->active()
			->withUrl($url)
			->find();

		if (!$model) throw new CHttpException(404, Yii::t('StoreModule.core', 'Продукт не найден.'));

		$view = $this->setDesign($model, 'view');

		$this->render($view, array(
			'model'=>$model,
		));
	}
}

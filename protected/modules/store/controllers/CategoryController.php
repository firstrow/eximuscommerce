<?php

/**
 * Display category products
 */
class CategoryController extends Controller
{

	/**
	 * Display products list
	 * @param string $url product url
	 */
	public function actionView($url)
	{
		var_dump($url);
		exit;

		// Find category
		$model = StoreCategory::model()
			->withUrl($url)
			->find();

		if (!$model) throw new CHttpException(404, Yii::t('StoreModule.core', 'Категория не найдена.'));

		$view = $this->setDesign($model, 'view');

		$this->render($view, array(
			'model'=>$model,
		));
	}
}

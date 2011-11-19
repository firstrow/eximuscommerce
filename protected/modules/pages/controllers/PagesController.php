<?php 
/**
 * Display pages.
 * @package modules.pages
 */
class PagesController extends Controller 
{

	/**
	 * Display page by url.
	 * Example url: /page/some-page-url
	 * @param string $url page url 
	 */
	public function actionView($url)
	{
		$model = Page::model()
			->published()
			->withUrl($url)
			->find();

		if (!$model) throw new CHttpException(404, Yii::t('PagesModule.core', 'Страница не найдена.'));

		// Set layout
		if ($model->layout)
			$this->layout = $model->layout;

		// Use custom page view
		if ($model->view)
			$view = $model->view;
		else
			$view = 'view';

		$this->render($view, array(
			'model'=>$model,
		));
	}
}
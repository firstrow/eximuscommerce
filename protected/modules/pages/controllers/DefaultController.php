<?php 

class DefaultController extends Controller 
{

	/**
	 * Display page by url.
	 * @param string $url page url 
	 */
	public function actionView($url)
	{
		$page = Page::model()
			->published()
			->withUrl($url)
			->find();

		if (!$page)
			throw new CHttpException(404, Yii::t('PagesModule.core', 'Страница не найдена.'));

		var_dump($page);
	}
}
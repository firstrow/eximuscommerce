<?php

Yii::import('application.modules.pages.models.Page');

/**
 * Store start page controller
 */
class IndexController extends Controller
{

	/**
	 * Display start page
	 */
	public function actionIndex()
	{
		$this->render('index', array(
			'popular' => $this->getPopular(4),
			'newest'  => $this->getNewest(4),
			'news'    => Page::model()->published()->filterByCategory(7)->findAll(array('limit'=>3))
		));
	}

	/**
	 * Renders products list to display on the start page
	 */
	public function actionRenderProductsBlock()
	{
		$scope = Yii::app()->request->getQuery('scope');
		switch($scope)
		{
			case 'newest':
				$this->renderBlock($this->getNewest(4));
				break;

			case 'added_to_cart':
				$this->renderBlock($this->getByAddedToCart(4));
				break;
		}
	}

	/**
	 * @param $products
	 */
	protected function renderBlock($products)
	{
		foreach($products as $p)
			$this->renderPartial('_product',array('data'=>$p));
	}

	/**
	 * @param $limit
	 * @return array
	 */
	protected function getPopular($limit)
	{
		return StoreProduct::model()
			->active()
			->byViews()
			->findAll(array('limit'=>$limit));
	}

	/**
	 * @param $limit
	 * @return array
	 */
	protected function getByAddedToCart($limit)
	{
		return StoreProduct::model()
			->active()
			->byAddedToCart()
			->findAll(array('limit'=>$limit));
	}

	/**
	 * @param $limit
	 * @return array
	 */
	protected function getNewest($limit)
	{
		return StoreProduct::model()
			->active()
			->newest()
			->findAll(array('limit'=>$limit));
	}

}

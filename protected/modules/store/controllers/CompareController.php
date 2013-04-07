<?php

Yii::import('application.modules.store.components.SCompareProducts');

/**
 * Compare products controller
 */
class CompareController extends Controller
{

	/**
	 * @var SCompareProducts
	 */
	public $model;

	public function beforeAction($action)
	{
		$this->model = new SCompareProducts;
		return true;
	}

	/**
	 * @var array
	 */
	protected $attributes=array();

	/**
	 * Render index view
	 */
	public function actionIndex()
	{
		$this->render('index');
	}

	/**
	 * Add product to compare list
	 * @param $id StoreProduct id
	 */
	public function actionAdd($id)
	{
		$this->model->add($id);
		$this->addFlashMessage(Yii::t('StoreModule.core', 'Продукт успешно добавлен в список сравнения.'));
		if(!Yii::app()->request->isAjaxRequest)
			$this->redirect($this->createUrl('index'));
	}

	/**
	 * Remove product from list
	 * @param string $id product id
	 */
	public function actionRemove($id)
	{
		$this->model->remove($id);
		if(!Yii::app()->request->isAjaxRequest)
			$this->redirect($this->createUrl('index'));
	}
}

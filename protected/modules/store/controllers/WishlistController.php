<?php

Yii::import('application.modules.store.components.SWishList');

/**
 * Display products added to wish list
 */
class WishlistController extends Controller
{


	/**
	 * @var StoreWishlist
	 */
	public $model;

	/**
	 * @param CAction $action
	 * @return bool
	 * @throws CHttpException
	 */
	public function beforeAction($action)
	{
		if(Yii::app()->user->isGuest && $this->action->id!=='view')
		{
			Yii::app()->user->returnUrl=Yii::app()->request->getUrl();
			if(Yii::app()->request->isAjaxRequest)
				throw new CHttpException(302);
			else
				$this->redirect(Yii::app()->user->loginUrl);
		}

		$this->model = new SWishList;
		return true;
	}

	/**
	 * Render index view
	 */
	public function actionIndex()
	{
		$this->render('index');
	}

	/**
	 * Add product to wish list
	 * @param $id StoreProduct id
	 */
	public function actionAdd($id)
	{
		$this->model->add($id);
		$this->addFlashMessage(Yii::t('StoreModule.core', 'Продукт успешно добавлен в список желаний.'));
		if(!Yii::app()->request->isAjaxRequest)
			$this->redirect($this->createUrl('index'));
	}

	/**
	 * @param $key
	 * @throws CHttpException
	 */
	public function actionView($key)
	{
		try{
			$this->model->loadByKey($key);
		}catch (CException $e) {
			throw new CHttpException(404, Yii::t('StoreModule.core', 'Ошибка. По вашему запросу ничего не найдено.'));
		}

		$this->render('index');
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

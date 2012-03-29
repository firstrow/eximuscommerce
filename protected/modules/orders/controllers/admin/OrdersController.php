<?php

Yii::import('store.models.*');
Yii::import('store.StoreModule');

/**
 * Admin orders
 */
class OrdersController extends SAdminController {

	/**
	 * Display orders methods list
	 */
	public function actionIndex()
	{
		$model = new Order('search');

		if (!empty($_GET['Order']))
			$model->attributes = $_GET['Order'];

		$dataProvider = $model->search();
		$dataProvider->pagination->pageSize = Yii::app()->params['adminPageSize'];

		$this->render('index', array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Create new order
	 */
	public function actionCreate()
	{
		$this->actionUpdate(true);
	}
	/**
	 * Update order
	 * @param bool $new
	 * @throws CHttpException
	 */
	public function actionUpdate($new = false)
	{
		if ($new === true)
		{
			$model = new Order;
			$model->unsetAttributes();
		}
		else
			$model = $this->_loadModel($_GET['id']);

		$deliveryMethods = StoreDeliveryMethod::model()->orderByName()->findAll();

		if (Yii::app()->request->isPostRequest)
		{
			$model->attributes = $_POST['Order'];

			if($model->validate())
			{
				$model->save();
			}
		}

		$this->render('update', array(
			'model'=>$model,
			'deliveryMethods'=>$deliveryMethods,
		));
	}

	/**
	 * Display gridview with list of products to add to order
	 * @param $order_id
	 */
	public function actionAddProductList($order_id)
	{
		$model = $this->_loadModel($order_id);
		$dataProvider = new StoreProduct('search');

		if(isset($_GET['StoreProduct']))
			$dataProvider->attributes = $_GET['StoreProduct'];

		$this->renderPartial('_addProduct', array(
			'order_id'=>$order_id,
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionAddProduct()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$order = $this->_loadModel($_POST['order_id']);
			$product = StoreProduct::model()->findByPk($_POST['product_id']);

			if(!$product)
				throw new CHttpException(404, Yii::t('OrdersModule.admin', 'Ошибка. Продукт не найден.'));

			$ordered_product = new OrderProduct;
			$ordered_product->order_id        = $order->id;
			$ordered_product->product_id      = $product->id;
			$ordered_product->name            = $product->name;
			$ordered_product->quantity        = $_POST['quantity'];
			$ordered_product->sku             = $product->sku;
			$ordered_product->price           = StoreProduct::calculatePrices($product, array(), 0);
			$ordered_product->save();
		}
	}

	/**
	 * Render ordered products after new product added.
	 * @param $order_id
	 */
	public function actionRenderOrderedProducts($order_id)
	{
		$this->renderPartial('_orderedProducts', array(
			'model'=>$this->_loadModel($order_id)
		));
	}

	/**
	 * Load order model
	 * @param $id
	 * @return CActiveRecord
	 * @throws CHttpException
	 */
	protected function _loadModel($id)
	{
		$model = Order::model()->findByPk($id);

		if (!$model)
			throw new CHttpException(404, Yii::t('OrdersModule.admin', 'Заказ не найден.'));

		return $model;
	}

	/**
	 * Delete order
	 * @param array $id
	 */
	public function actionDelete($id = array())
	{
		if (Yii::app()->request->isPostRequest)
		{
			$model = Order::model()->findAllByPk($_REQUEST['id']);

			if (!empty($model))
			{
				foreach($model as $m)
					$m->delete();
			}

			if (!Yii::app()->request->isAjaxRequest)
				$this->redirect('index');
		}
	}

}

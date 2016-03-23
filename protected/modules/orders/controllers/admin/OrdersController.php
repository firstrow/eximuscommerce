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
		$dataProvider->pagination->pageSize = Yii::app()->settings->get('core', 'productsPerPageAdmin');

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

		if(Yii::app()->request->isPostRequest)
		{
			$model->attributes = $_POST['Order'];

			if($model->validate())
			{
				$model->save();

				// Update quantities
				if(sizeof(Yii::app()->request->getPost('quantity', array())))
					$model->setProductQuantities(Yii::app()->request->getPost('quantity'));

				$model->updateDeliveryPrice();
				$model->updateTotalPrice();

				$this->setFlashMessage(Yii::t('OrdersModule.admin', 'Изменения успешно сохранены'));

				if(isset($_POST['REDIRECT']))
					$this->smartRedirect($model);
				else
					$this->redirect(array('index'));
			}
		}

		$this->render('update', array(
			'deliveryMethods' => StoreDeliveryMethod::model()->applyTranslateCriteria()->orderByName()->findAll(),
			'statuses'        => OrderStatus::model()->orderByPosition()->findAll(),
			'model'           => $model,
		));
	}

	/**
	 * Display gridview with list of products to add to order
	 */
	public function actionAddProductList()
	{
		$order_id     = Yii::app()->request->getQuery('id');
		$model        = $this->_loadModel($order_id);
		$dataProvider = new StoreProduct('search');

		if(isset($_GET['StoreProduct']))
			$dataProvider->attributes = $_GET['StoreProduct'];

		$this->renderPartial('_addProduct', array(
			'dataProvider' => $dataProvider,
			'order_id'     => $order_id,
			'model'        => $model,
		));
	}

	/**
	 * Add product to order
	 * @throws CHttpException
	 */
	public function actionAddProduct()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$order   = $this->_loadModel($_POST['order_id']);
			$product = StoreProduct::model()->findByPk($_POST['product_id']);

			if(!$product)
				throw new CHttpException(404, Yii::t('OrdersModule.admin', 'Ошибка. Продукт не найден.'));

			$order->addProduct($product, $_POST['quantity'], $_POST['price']);
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
	 * Get ordered products in json format.
	 * Result is displayed in the orders list.
	 */
	public function actionJsonOrderedProducts()
	{
		$model = $this->_loadModel(Yii::app()->request->getQuery('id'));
		$data  = array();

		foreach($model->getOrderedProducts()->getData() as $product)
		{
			$data[]=array(
				'name'     => $product->renderFullName,
				'quantity' => $product->quantity,
				'price'    => StoreProduct::formatPrice($product->price),
			);
		}

		echo CJSON::encode($data);
	}

	/**
	 * Load order model
	 * @param $id
	 * @return Order
	 * @throws CHttpException
	 */
	protected function _loadModel($id)
	{
		$model = Order::model()->findByPk($id);

		if (!$model)
			$this->error404();

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

	/**
	 * Delete product from order
	 */
	public function actionDeleteProduct()
	{
		$order = Order::model()->findByPk(Yii::app()->request->getPost('order_id'));

		if(!$order)
			$this->error404();

		$order->deleteProduct(Yii::app()->request->getPost('id'));
	}

	/**
	 * Render order history tab
	 */
	public function actionHistory()
	{
		$id    = Yii::app()->request->getQuery('id');
		$model = Order::model()->findByPk($id);

		if(!$model)
			$this->error404();

		$this->render('_history', array(
			'model'=>$model
		));
	}

	/**
	 * @throws CHttpException
	 */
	public function error404()
	{
		throw new CHttpException(404, Yii::t('OrdersModule.admin', 'Заказ не найден.'));
	}
}

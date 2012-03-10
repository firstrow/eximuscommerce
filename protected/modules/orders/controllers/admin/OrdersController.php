<?php

Yii::import('store.models.*');

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
			$model = Order::model()->findByPk($_GET['id']);

		if (!$model)
			throw new CHttpException(404, Yii::t('OrdersModule.admin', 'Заказ не найден.'));

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

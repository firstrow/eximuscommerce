<?php

Yii::import('application.modules.orders.models.*');
Yii::import('application.modules.orders.components.*');
Yii::import('application.modules.store.models.*');
Yii::import('application.modules.comments.models.*');
Yii::import('application.modules.comments.CommentsModule');

class DefaultController extends SAdminController
{

	/**
	 * Display admin start page.
	 */
	public function actionIndex()
	{
		$this->render('index', array(
			'ordersDataProvider'=>$this->getOrders(),
		));
	}

	/**
	 * Get latest orders
	 *
	 * @return CActiveDataProvider
	 */
	public function getOrders()
	{
		$cr = new CDbCriteria;

		$orders = Order::model()->search();
		$orders->setPagination(array('pageSize'=>10));
		$orders->setCriteria($cr);

		return $orders;
	}

	/**
	 * Get orders created today
	 *
	 * @return CActiveDataProvider
	 */
	public function getTodayOrders()
	{
		$cr = new CDbCriteria;
		$cr->addCondition('created >= "'.date('Y-m-d 00:00:00').'"');

		$dataProvider = Order::model()->search();
		$dataProvider->setCriteria($cr);

		return $dataProvider;
	}

	/**
	 * Sum orders total price
	 *
	 * @return string
	 */
	public function getOrdersTotalPrice()
	{
		$total = 0;
		foreach ($this->getTodayOrders()->getData() as $order)
			$total += $order->full_price;

		return StoreProduct::formatPrice($total);
	}

	public function countTodayComments()
	{
		$cr = new CDbCriteria;
		$cr->addCondition('created >= "'.date('Y-m-d 00:00:00').'"');

		return Comment::model()->count($cr);
	}
}

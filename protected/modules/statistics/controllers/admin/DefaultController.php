<?php

Yii::import('application.modules.orders.models.Order');

class DefaultController extends SAdminController
{

	/**
	 * Display stats by count
	 */
	public function actionIndex()
	{
		$data       = array();
		$data_total = array();
		$request    = Yii::app()->request;

		$year    = (int)$request->getParam('year', date('Y'));
		$month   = (int)$request->getParam('month', date('n'));

		$orders  = $this->loadOrders($year, $month);
		$grouped = $this->groupOrdersByDay($orders);

		for($i=1;$i<=cal_days_in_month(CAL_GREGORIAN, $month, $year); ++$i)
		{
			$count = 0;
			$totalPrice = 0;
			if(array_key_exists($i, $grouped))
			{
				$count = sizeof($grouped[$i]);
				$totalPrice = $this->getTotalPrice($grouped[$i]);
			}

			$data[]       = array('day'=>$i, 'value'=>$count);
			$data_total[] = array('day'=>$i, 'value'=>$totalPrice);
		}

		$this->render('index', array(
			'data'  => $data,
			'data_total'  => $data_total,
			'year'  => $year,
			'month' => $month
		));
	}

	/**
	 * @param $year
	 * @param $month
	 * @return array
	 */
	public function loadOrders($year, $month)
	{
		$date_match = (int)$year . '-' . (int)$month;

		$query = new CDbCriteria( array(
			'condition' => "created LIKE '$date_match%'"
		));

		return Order::model()->findAll($query);
	}

	public function groupOrdersByDay(array $orders)
	{
		$result = array();

		foreach($orders as $order)
		{
			$day = date('j', strtotime($order->created));
			if(!isset($result[$day]))
				$result[$day]=array();

			$result[$day][] = $order;
		}

		return $result;
	}

	/**
	 * @param array $orders
	 * @return int
	 */
	public function getTotalPrice(array $orders)
	{
		$result = 0;

		foreach ($orders as $o)
			$result += $o->getFull_price();

		return $result;
	}

	/**
	 * @return array
	 */
	public function getAvailableYears()
	{
		$result = array();
		$command = Yii::app()->db->createCommand('SELECT created FROM `Order` order by created')->queryAll();

		foreach($command as $row)
		{
			$year = date('Y',strtotime($row['created']));
			$result[$year] = $year;
		}

		return $result;
	}
}

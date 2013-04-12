<?php

Yii::import('application.modules.orders.models.Order');
Yii::import('application.modules.comments.models.Comment');

class AjaxController extends SAdminController
{
	public function actionGetCounters()
	{
		echo json_encode(array(
			'comments' => (int ) Comment::model()->waiting()->count(),
			'orders'   => (int ) Order::model()->new()->count(),
		));
	}
}
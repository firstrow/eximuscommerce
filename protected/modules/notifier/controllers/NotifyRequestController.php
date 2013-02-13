<?php

class NotifyRequestController extends Controller
{

	/**
	 * Add new email to list
	 */
	public function actionIndex()
	{
		$product = StoreProduct::model()->findByPk(Yii::app()->request->getPost('product_id'));

		if(!$product)
			throw new CHttpException(404);

		$record = new ProductNotifications();
		$record->attributes = array(
			'email'=>$_POST['email']
		);
		$record->product_id = $product->id;

		if($record->validate() && $record->hasEmail() === false)
			$record->save();
	}

}
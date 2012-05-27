<?php

Yii::import('application.modules.store.models.StorePaymentMethod');

/**
 * Process payments
 */
class PaymentController extends Controller
{
	public function actionProcess()
	{
		$payment_id = (int) Yii::app()->request->getParam('payment_id');
		$model      = StorePaymentMethod::model()->findByPk($payment_id);

		if(!$model)
			throw new CHttpException(404);

		$system = $model->getPaymentSystemClass();
		if($system instanceof BasePaymentSystem)
		{
			$order=$system->processPaymentRequest($model);
			if($order instanceof Order)
				$this->redirect('/cart/cart/view', array('key'=>$order->key));
			else
				throw new CHttpException(404, Yii::t('Возникла ошибка при обработке запроса.'));
		}
	}
}

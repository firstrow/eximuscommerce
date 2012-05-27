<?php

Yii::import('application.modules.store.models.StorePaymentMethod');

/**
 * Process payments
 */
class PaymentController extends Controller
{

	public function actionProcess()
	{
		if(Yii::app()->request->getParam('Shp_pmId'))
			$_GET['payment_id']=$_GET['Shp_pmId'];

		$payment_id = (int) Yii::app()->request->getParam('payment_id');
		$model      = StorePaymentMethod::model()->findByPk($payment_id);

		if(!$model)
			throw new CHttpException(404, 'Ошибка');

		$system = $model->getPaymentSystemClass();
		if($system instanceof BasePaymentSystem)
		{
			$response=$system->processPaymentRequest($model);
			if($response instanceof Order)
				$this->redirect($this->createUrl('/cart/cart/view', array('key'=>$response->key)));
			else
				throw new CHttpException(404, Yii::t('OrdersModule.core', 'Возникла ошибка при обработке запроса. <br> {err}', array('{err}'=>$response)));
		}
	}

}

<?php

Yii::import('ext.payment.robokassa.*');

/**
 * Robokassa payment system
 */
class RobokassaPaymentSystem extends BasePaymentSystem
{

	/**
	 * @var bool
	 */
	public $testingMode=YII_DEBUG;

	/**
	 * This method will be triggered after redirection from payment system site.
	 * If payment accepted method must return Order model to make redirection to order view.
	 * @param StorePaymentMethod $method
	 * @return boolean|Order
	 */
	public function processPaymentRequest(StorePaymentMethod $method)
	{
		$request  = Yii::app()->request;
		$settings = $this->getSettings($method->id);
		$order    = Order::model()->findByAttributes(array('secret_key'=>$request->getParam('Shp_orderKey')));

		if($order->paid)
			return false;

		$mrh_pass2      = $settings['password2'];
		$shp_order_key  = $order->secret_key;
		$shp_payment_id = $method->id;

		$out_sum  = $request->getParam("OutSum");
		$inv_id   = $request->getParam("InvId");
		$crc      = strtoupper($request->getParam("SignatureValue"));
		$my_crc   = strtoupper(md5("$out_sum:$inv_id:$mrh_pass2:Shp_orderKey=$shp_order_key:Shp_pmId=$shp_payment_id"));

		// Check sum
		if ($out_sum != $order->full_price)
			return ERROR_SUM;

		// Check sign
		if ($my_crc != $crc)
			return "bad sign $out_sum:$inv_id:Shp_orderKey=$shp_order_key:Shp_pmId=$shp_payment_id";

		// Set order paid
		$order->paid=1;
		$order->save();

		// Show answer for Robokassa API service
		if (isset($_REQUEST['getResult']) && $_REQUEST['getResult'] == 'true')
			exit("OK".$order->id);

		return $order;
	}

	/**
	 * Generate robokassa payment form.
	 * @param StorePaymentMethod $method
	 * @param Order $order
	 * @return string
	 */
	public function renderPaymentForm(StorePaymentMethod $method, Order $order)
	{
		$settings=$this->getSettings($method->id);

		// Registration data
		$mrh_login = $settings['login'];
		$mrh_pass1 = $settings['password1'];
		$shp_order_key = $order->secret_key;
		$shp_payment_id = $method->id;

		// Order number
		$inv_id = $order->id;
		// Order description
		$inv_desc = Yii::t('core', "Оплата заказа #") . $order->id;
		// Order sum
		$out_sum = $order->full_price;
		// currency
		$in_curr = "PCR";
		// Language
		$culture = "ru";
		// Signature
		$crc = md5("$mrh_login:$out_sum:$inv_id:$mrh_pass1:Shp_orderKey=$shp_order_key:Shp_pmId=$shp_payment_id");

		if($this->testingMode)
			$html = CHtml::form('http://test.robokassa.ru/Index.aspx');
		else
			$html = CHtml::form('https://merchant.roboxchange.com/Index.aspx');

		$html .= CHtml::hiddenField('MrchLogin', $mrh_login);
		$html .= CHtml::hiddenField('OutSum', $out_sum);
		$html .= CHtml::hiddenField('InvId', $inv_id);
		$html .= CHtml::hiddenField('Desc', $inv_desc);
		$html .= CHtml::hiddenField('SignatureValue', $crc);
		$html .= CHtml::hiddenField('Shp_orderKey', $shp_order_key);
		$html .= CHtml::hiddenField('Shp_pmId', $shp_payment_id);
		$html .= CHtml::hiddenField('IncCurrLabel', $in_curr);
		$html .= CHtml::hiddenField('Culture', $culture);
		$html .= $this->renderSubmit();

		return $html;
	}

	/**
	 * This method will be triggered after payment method saved in admin panel
	 * @param $paymentMethodId
	 * @param $postData
	 */
	public function saveAdminSettings($paymentMethodId, $postData)
	{
		$this->setSettings($paymentMethodId, $postData['RobokassaConfigurationModel']);
	}

	/**
	 * @param $paymentMethodId
	 * @return string
	 */
	public function getSettingsKey($paymentMethodId)
	{
		return $paymentMethodId.'_RobokassaPaymentSystem';
	}

	/**
	 * Get configuration form to display in admin panel
	 * @param string $paymentMethodId
	 * @return CForm
	 */
	public function getConfigurationFormHtml($paymentMethodId)
	{
		$model = new RobokassaConfigurationModel();
		$model->attributes=$this->getSettings($paymentMethodId);
		$form  = new CForm($model->getFormConfigArray(), $model);
		return $form;
	}

}

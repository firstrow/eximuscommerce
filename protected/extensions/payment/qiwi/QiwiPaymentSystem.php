<?php

Yii::import('ext.payment.qiwi.*');

/**
 * Qiwi payment system
 */
class QiwiPaymentSystem extends BasePaymentSystem
{

	/**
	 * This method will be triggered after redirection from payment system site.
	 * If payment accepted method must return Order model to make redirection to order view.
	 * @param StorePaymentMethod $method
	 * @return boolean|Order
	 */
	public function processPaymentRequest(StorePaymentMethod $method)
	{
		$settings = $this->getSettings($method->id);
		
		$cr = new CDbCriteria;
		$cr->order = 'created DESC';
		$orders = Order::model()->findAllByAttributes(array(
			'paid' => 0,
		));
		$orders = $this->prepareOrders($orders);

		$xmlResponse = $this->requestStatuses($orders, $settings);

		foreach($xmlResponse->{'bills-list'}->{'bill'} as $bill)
		{
			if((int)$bill->attributes()->{'status'} === 60)
			{
				$orderId = (string)$bill->attributes()->{'status'};
				if(isset($orders[$orderId]))
				{
					$order->paid = true;
					$order->save();
				}
			}
		}

		if(Yii::app()->request->getQuery('redirect'))
			Yii::app()->request->redirect( Yii::app()->request->getQuery('redirect') );
		Yii::app()->request->redirect('/');
	}

	/**
	 * Generate qiwi payment form.
	 * @param StorePaymentMethod $method
	 * @param Order $order
	 * @return string
	 */
	public function renderPaymentForm(StorePaymentMethod $method, Order $order)
	{
		$settings=$this->getSettings($method->id);

		$summ = Yii::app()->currency->convert($order->full_price, $method->currency_id);

		$html = '<div class="form">';
		$html .= CHtml::form('http://w.qiwi.ru/setInetBill_utf.do', 'get');
		$html .= CHtml::hiddenField('from', $settings['shop_id']);
		$html .= CHtml::hiddenField('summ', $summ);
		$html .= CHtml::hiddenField('com', $this->getPaymentComment($order));
		$html .= CHtml::hiddenField('txn_id', $order->id);
		$html .= '<div id="qiwi_phone_number">Номер телефона:<br/>';
		$html .= CHtml::textField('to', $order->user_phone);
		$html .= '</div>';
		$html .= $this->renderSubmit();
		$html .= CHtml::endForm();
		$html .= '</div>';

		return $html;
	}

	/**
	 * This method will be triggered after payment method saved in admin panel
	 * @param $paymentMethodId
	 * @param $postData
	 */
	public function saveAdminSettings($paymentMethodId, $postData)
	{
		$this->setSettings($paymentMethodId, $postData['QiwiConfigurationModel']);
	}

	/**
	 * @param $paymentMethodId
	 * @return string
	 */
	public function getSettingsKey($paymentMethodId)
	{
		return $paymentMethodId.'_QiwiPaymentSystem';
	}

	/**
	 * Get configuration form to display in admin panel
	 * @param string $paymentMethodId
	 * @return CForm
	 */
	public function getConfigurationFormHtml($paymentMethodId)
	{
		$model = new QiwiConfigurationModel();
		$model->attributes=$this->getSettings($paymentMethodId);
		$form  = new CForm($model->getFormConfigArray(), $model);
		return $form;
	}

	/**
	 * Create bill comment contains list of products
	 */
	private function getPaymentComment($order)
	{
		$result = array();

		foreach ($order->products as $product)
			$result[] = $product->name;

		return implode(', ', $result);
	}

	public function requestStatuses($orders, $settings)
	{
		$xmlRequest  = '<?xml version="1.0" encoding="utf-8"?><request>';
		$xmlRequest .= '<protocol-version>4.00</protocol-version>';
		$xmlRequest .= '<request-type>33</request-type>';
		$xmlRequest .= '<extra name="password">' .$settings['password']. '</extra>';
		$xmlRequest .= '<terminal-id>' .$settings['shop_id']. '</terminal-id>';
		$xmlRequest .= '<bills-list>';
		
		foreach($orders as $order)
			$xmlRequest .= '<bill txn-id="'.$order->id.'"/>';

		$xmlRequest .= '</bills-list>';
		$xmlRequest .= '</request>';

		// Request statuses
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://ishop.qiwi.ru/xml');
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type' => 'text/xml; encoding=utf-8'));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlRequest);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$result = curl_exec($ch);
		curl_close($ch);

		return simplexml_load_string($result);
	}

	public function prepareOrders($orders)
	{
		$result = array();
		foreach ($orders as $order)
			$result[$order->id] = $order;
		return $result;
	}
}

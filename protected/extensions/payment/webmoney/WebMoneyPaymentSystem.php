<?php

Yii::import('ext.payment.webmoney.WebMoneyConfigurationModel');

/**
 * WebMoney payment system
 */
class WebMoneyPaymentSystem extends BasePaymentSystem
{

	/**
	 * Enable testing mode
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
		$order    = Order::model()->findByPk(Yii::app()->request->getParam('LMI_PAYMENT_NO'));

		if($order===false)
			return false;

		// For first WebMoney pre-request
		if (!isset($_POST['LMI_HASH']) && isset($_GET['result']))
			die('YES');

		$SECRET_KEY = $settings['LMI_SECRET_KEY'];
		$PURSE      = $settings['LMI_PAYEE_PURSE'];

		// Grab WM variables from post.
		// Variables to create md5 signature.
		$forHash = array(
			'LMI_PAYEE_PURSE'    => '',
			'LMI_PAYMENT_AMOUNT' => '',
			'LMI_PAYMENT_NO'     => '',
			'LMI_MODE'           => '',
			'LMI_SYS_INVS_NO'    => '',
			'LMI_SYS_TRANS_NO'   => '',
			'LMI_SYS_TRANS_DATE' => '',
			'LMI_SECRET_KEY'     => '',
			'LMI_PAYER_PURSE'    => '',
			'LMI_PAYER_WM'       => '',
		);

		foreach($forHash as $key=>$val)
		{
			if($request->getParam($key))
				$forHash[$key]=$request->getParam($key);
		}

		// Set Secret key from settings.
		$forHash['LMI_SECRET_KEY'] = $SECRET_KEY;

		// Check testing mode
		if ($this->testingMode === true)
			$forHash['LMI_MODE'] = 1;
		else
			$forHash['LMI_MODE'] = 0;

		// Check if order is paid.
		if ($order->paid)
			return false;

		// Check LMI_PAYEE_PURSE with settings.
		if ($PURSE != $forHash['LMI_PAYEE_PURSE'])
			return false;

		// Check amount.
		if ($order->full_price != $forHash['LMI_PAYMENT_AMOUNT'])
			return false;

		// Check payer and shop WM accounts first letter.
		if (($PURSE{0} != $forHash['LMI_PAYEE_PURSE']{0}))
			return false;

		// Check for testing payment.
		if ($forHash['LMI_MODE'] == 1 && $this->testingMode == false)
			return false;

		if (!$request->getParam('LMI_HASH'))
			return false;

		// Create and check signature.
		$sign = strtoupper(md5(implode('',$forHash)));

		// If ok make order paid.
		if ($sign != $request->getParam('LMI_HASH'))
			return false;

		// Set order paid
		$order->paid=1;
		$order->save();

		if ($request->getParam('result') && $request->getParam('result')=='1')
			die("YES");

		return $order;
	}

	public function renderPaymentForm(StorePaymentMethod $method, Order $order)
	{
		$html = '
		<form method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp" accept-charset="windows-1251">
			<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="{PAYMENT_AMOUNT}">
			<input type="hidden" name="LMI_PAYMENT_NO" value="{PAYMENT_NO}">
			<input type="hidden" name="LMI_PAYMENT_DESC" value="{PAYMENT_DESC}">
			<input type="hidden" name="LMI_PAYEE_PURSE" value="{PAYEE_PURSE}">
			<input type="hidden" name="LMI_RESULT_URL" value="{RESULT_URL}">
			<input type="hidden" name="LMI_SUCCESS_URL" value="{SUCCESS_URL}">
			<input type="hidden" name="LMI_FAIL_URL" value="{FAIL_URL}">
			{SUBMIT}
		</form>';

		$settings=$this->getSettings($method->id);

		$html= strtr($html,array(
			'{PAYMENT_AMOUNT}' => $order->full_price,
			'{PAYMENT_NO}'     => $order->id,
			'{PAYMENT_DESC}'   => Yii::t('core', "Оплата заказа #").$order->id,
			'{PAYEE_PURSE}'    => $settings['LMI_PAYEE_PURSE'],
			'{SIM_MODE}'       => '0',
			'{SUCCESS_URL}'    => Yii::app()->createAbsoluteUrl('/orders/payment/process', array('payment_id'=>$method->id)),
			'{RESULT_URL}'     => Yii::app()->createAbsoluteUrl('/orders/payment/process', array('payment_id'=>$method->id, 'result'=>true)),
			'{FAIL_URL}'       => Yii::app()->createAbsoluteUrl('/orders/payment/process', array('payment_id'=>$method->id, 'fail'=>true)),
			'{SUBMIT}'         => $this->renderSubmit(),
		));

		return $html;
	}

	/**
	 * This method will be triggered after payment method saved in admin panel
	 * @param $paymentMethodId
	 * @param $postData
	 */
	public function saveAdminSettings($paymentMethodId, $postData)
	{
		$this->setSettings($paymentMethodId, $postData['WebMoneyConfigurationModel']);
	}

	/**
	 * @param $paymentMethodId
	 * @return string
	 */
	public function getSettingsKey($paymentMethodId)
	{
		return $paymentMethodId.'_WebMoneyPaymentSystem';
	}

	/**
	 * Get configuration form to display in admin panel
	 * @param string $paymentMethodId
	 * @return CForm
	 */
	public function getConfigurationFormHtml($paymentMethodId)
	{
		$model = new WebMoneyConfigurationModel;
		$model->attributes=$this->getSettings($paymentMethodId);
		$form  = new CForm($model->getFormConfigArray(), $model);
		return $form;
	}

}

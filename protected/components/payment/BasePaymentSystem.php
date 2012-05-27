<?php

class BasePaymentSystem extends CComponent
{

	/**
	 * @return string
	 */
	public function renderSubmit()
	{
		return '<input type="submit" value="'.Yii::t('core','Оплатить').'">';
	}

	/**
	 * @param $paymentMethodId
	 * @param $data
	 */
	public function setSettings($paymentMethodId, $data)
	{
		Yii::app()->settings->set($this->getSettingsKey($paymentMethodId), $data);
	}

	/**
	 * @param $paymentMethodId
	 */
	public function getSettings($paymentMethodId)
	{
		return Yii::app()->settings->get($this->getSettingsKey($paymentMethodId));
	}

}
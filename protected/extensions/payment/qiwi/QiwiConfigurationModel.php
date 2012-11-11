<?php

class QiwiConfigurationModel extends CModel
{

	public $shop_id;
	public $password;

	/**
	 * @return array
	 */
	public function rules()
	{
		return array(
			array('shop_id, password', 'type')
		);
	}

	/**
	 * @return array
	 */
	public function attributeNames()
	{
		return array(
			'shop_id'  => Yii::t('QiwiPaymentSystem', 'ID QIWI Кошелька'),
			'password' => Yii::t('QiwiPaymentSystem', 'Пароль'),
		);
	}

	/**
	 * @return array
	 */
	public function getFormConfigArray()
	{
		$id=Yii::app()->request->getQuery('payment_method_id');
		if($id==='undefined')
			$successUrl = 'Для получениия ссылки нужно сохранить запись.';
		else
			$successUrl = Yii::app()->createAbsoluteUrl('/orders/payment/process', array('payment_id'=>$id)).'?redirect=СCЫЛКА_СТРАНИЦЫ_УСПЕШНОЙ_ОПЛАТЫ';

		return array(
			'type'=>'form',
			'elements'=>array(
				'shop_id'=>array(
					'label'=>Yii::t('QiwiPaymentSystem', 'ID QIWI Кошелька'),
					'type'=>'text',
					'hint'=>'Пример: 2042',
				),
				'password'=>array(
					'label'=>Yii::t('QiwiPaymentSystem', 'Пароль'),
					'type'=>'text',
				),
				'<div class="row">
					<label>URL для отправки в случае успешной оплаты счёта</label>
					'.$successUrl.'
				</div>
				'
		));
	}
}

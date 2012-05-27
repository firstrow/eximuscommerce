<?php

class WebMoneyConfigurationModel extends CModel
{

	public $LMI_PAYEE_PURSE;
	public $LMI_SECRET_KEY;

	public function rules()
	{
		return array(
			array('LMI_PAYEE_PURSE, LMI_SECRET_KEY', 'type')
		);
	}

	public function attributeNames()
	{
		return array(
			'LMI_PAYEE_PURSE' => Yii::t('WebMoneyPaymentSystem', 'Ваш кошелек'),
			'LMI_SECRET_KEY'  => Yii::t('WebMoneyPaymentSystem', 'Секретный ключ'),
		);
	}

	public function getFormConfigArray()
	{
		return array(
			'type'=>'form',
			'elements'=>array(
				'LMI_PAYEE_PURSE'=>array(
					'label'=>Yii::t('WebMoneyPaymentSystem', 'Ваш кошелек'),
					'type'=>'text',
				),
				'LMI_SECRET_KEY'=>array(
					'label'=>Yii::t('WebMoneyPaymentSystem', 'Секретный ключ'),
					'type'=>'text',
				),
		));
	}
}

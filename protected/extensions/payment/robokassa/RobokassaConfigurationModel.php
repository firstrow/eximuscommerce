<?php

class RobokassaConfigurationModel extends CModel
{

	public $login;
	public $password1;
	public $password2;

	/**
	 * @return array
	 */
	public function rules()
	{
		return array(
			array('login, password1, password2 ', 'type')
		);
	}

	/**
	 * @return array
	 */
	public function attributeNames()
	{
		return array(
			'login' => Yii::t('WebMoneyPaymentSystem', 'Логин'),
			'password1' => Yii::t('WebMoneyPaymentSystem', 'Пароль 1'),
			'password2' => Yii::t('WebMoneyPaymentSystem', 'Пароль 2'),
		);
	}

	/**
	 * @return array
	 */
	public function getFormConfigArray()
	{
		return array(
			'type'=>'form',
			'elements'=>array(
				'login'=>array(
					'label'=>Yii::t('WebMoneyPaymentSystem', 'Логин'),
					'type'=>'text',
				),
				'password1'=>array(
					'label'=>Yii::t('WebMoneyPaymentSystem', 'Пароль 1'),
					'type'=>'text',
				),
				'password2'=>array(
					'label'=>Yii::t('WebMoneyPaymentSystem', 'Пароль 2'),
					'type'=>'text',
				),
			));
	}
}

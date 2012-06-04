<?php


class AccountingConfigForm extends CFormModel
{

	public $ip;
	public $password;

	public function init()
	{
		$this->attributes = Yii::app()->settings->get('accounting1c');
	}

	/**
	 * Validation rules
	 * @return array
	 */
	public function rules()
	{
		return array(
			array('ip, password', 'required'),
		);
	}

	/**
	 * @return array
	 */
	public function attributeLabels()
	{
		return array(
			'ip'=>'IP',
			'password'=>Yii::t('Accounting1cModule.admin','Пароль')
		);
	}

	/**
	 * Save settings
	 */
	public function save()
	{
		Yii::app()->settings->set('accounting1c', $this->attributes);
	}

}

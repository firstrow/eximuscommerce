<?php

/**
 * Configure 1C import access settings
 */
class AccountingConfigForm extends CFormModel
{

	public $ip;
	public $password;
	public $tempdir;

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
			array('ip, password, tempdir', 'required'),
		);
	}

	/**
	 * @return array
	 */
	public function attributeLabels()
	{
		return array(
			'ip'=>'IP',
			'password'=>Yii::t('Accounting1cModule.admin','Пароль'),
			'tempdir'=>Yii::t('Accounting1cModule.admin','Директория')
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

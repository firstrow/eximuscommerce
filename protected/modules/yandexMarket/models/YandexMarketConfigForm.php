<?php

class YandexMarketConfigForm extends CFormModel
{
	public $name;
	public $company;
	public $url;
	public $currency_id;

	public function init()
	{
		$this->attributes = Yii::app()->settings->get('yandexMarket');
	}

	/**
	 * Validation rules
	 * @return array
	 */
	public function rules()
	{
		return array(
			array('name, company, url', 'required'),
			array('name', 'length', 'max'=>20),
			array('currency_id', 'checkCurrency'),
		);
	}

	public function checkCurrency()
	{
		$currencies=Yii::app()->currency->getCurrencies();
		if(!array_key_exists($this->currency_id, $currencies))
			$this->addError('currency_id', Yii::t('YandexMarketModule.admin', 'Ошибка провеки валюты.'));
	}

	/**
	 * @return array
	 */
	public function attributeLabels()
	{
		return array(
			'name'        => Yii::t('YandexMarketModule.admin','Название магазина'),
			'company'     => Yii::t('YandexMarketModule.admin','Название компании'),
			'url'         => Yii::t('YandexMarketModule.admin','Полный URL сайта'),
			'currency_id' => Yii::t('YandexMarketModule.admin','Валюта')
		);
	}

	public function getCurrencies()
	{
		$result=array();
		foreach(Yii::app()->currency->getCurrencies() as $id=>$model)
			$result[$id]=$model->name;
		return $result;
	}

	/**
	 * Save settings
	 */
	public function save()
	{
		Yii::app()->settings->set('yandexMarket', $this->attributes);
	}
}

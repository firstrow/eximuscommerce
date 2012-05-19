<?php

Yii::import('application.modules.store.models.StoreCurrency');

/**
 * Class to work with currencies
 */
class SCurrencyManager extends CComponent
{

	/**
	 * @var array available currencies
	 */
	private $_currencies = array();

	/**
	 * @var StoreCurrency main currency
	 */
	private $_main;

	/**
	 * @var StoreCurrency currenct active currency
	 */
	private $_active;

	/**
	 * @var StoreCurrency default currency
	 */
	private $_default;

	public function init()
	{
		// Load currencies
		$query = StoreCurrency::model()->findAll();
		foreach($query as $currency)
		{
			$this->_currencies[$currency->id] = $currency;
			if($currency->main)
				$this->_main = $currency;
			if($currency->default)
				$this->_default = $currency;
		}

		$this->setActive($this->detectActive()->id);
	}

	/**
	 * @return array
	 */
	public function getCurrencies()
	{
		return $this->_currencies;
	}

	/**
	 * Detect user active currency
	 * @return StoreCurrency
	 */
	public function detectActive()
	{
		// Detect currency from session
		$sessCurrency = Yii::app()->session['currency'];

		if($sessCurrency && isset($this->_currencies[$sessCurrency]))
			return $this->_currencies[$sessCurrency];
		return $this->_default;
	}

	/**
	 * @param int $id currency id
	 */
	public function setActive($id)
	{
		if(isset($this->_currencies[$id]))
			$this->_active = $this->_currencies[$id];
		else
			$this->_active = $this->_default;

		Yii::app()->session['currency'] = $this->_active->id;
	}

	/**
	 * get active currency
	 * @return StoreCurrency
	 */
	public function getActive()
	{
		return $this->_active;
	}

	/**
	 * @return StoreCurrency main currency
	 */
	public function getMain()
	{
		return $this->_main;
	}

	/**
	 * Convert cum from main currency to selected currency
	 * @param mixed $sum
	 * @param mixed $id StoreCurrency. If not set, sum will be converted to active currency
	 * @return float converted sum
	 */
	public function convert($sum, $id=null)
	{
		if($id !== null && isset($this->_currencies[$id]))
			$currency = $this->_currencies[$id];
		else
			$currency = $this->_active;

		return $currency->rate * $sum;
	}

	/**
	 * Convert from active currency to main
	 * @param $sum
	 * @return float
	 */
	public function activeToMain($sum)
	{
		return $sum / $this->getActive()->rate;
	}
}

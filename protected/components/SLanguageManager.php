<?php

class SLanguageManager extends CApplicationComponent {

	/**
	 * @var array available system languages
	 */
	protected $_languages = array();

	/**
	 * @var string Active lang code
	 */
	protected $_active;

	/**
	 * @var string Default lang code
	 */
	protected $_default;

	public function init()
	{
		if (empty($this->_languages))
			$this->loadLanguages();
	}

	/**
	 * Load available languages.
	 * @return SSystemLanguage collection
	 */
	private function loadLanguages()
	{
		$model = SSystemLanguage::model()->findAll();
		foreach($model as $lang)
		{
			$this->_languages[$lang->code] = $lang;
			if($lang->default === '1')
				$this->_default = $lang->code;
		}
		return $this->_languages;
	}

	/**
	 * Get system languages
	 * @return array
	 */
	public function getLanguages()
	{
		return $this->_languages;
	}

	/**
	 * Get lang by its code
	 * @param string $langCode
	 * @return SSystemLanguage
	 */
	public function getByCode($langCode)
	{
		if (isset($this->_languages[$langCode]))
			return $this->_languages[$langCode];
	}

	/**
	 * Get language by its id
	 * @param integer $langId Language id
	 * @return mixed SSystemLanguage if lang found. Null if not.
	 */
	public function getById($langId)
	{
		foreach($this->languages as $lang)
		{
			if ($lang->id == $langId)
				return $lang;
		}
	}

	/**
	 * Get language codes
	 * @return array array('en','ru',...)
	 */
	public function getCodes()
	{
		return array_keys($this->_languages);
	}

	/**
	 * Get default system model
	 * @return SSystemLanguage
	 */
	public function getDefault()
	{
		return $this->getByCode($this->_default);
	}

	/**
	 * Get active language model
	 * @return SSystemLanguage
	 */
	public function getActive()
	{
		return $this->getByCode($this->_active);
	}

	/**
	 * Activate language by code
	 * @param string $code Language code.
	 */
	public function setActive($code=null)
	{
		$model = $this->getByCode($code);

		if (!$model)
			$model = $this->default;

		Yii::trace('Activating language '.$model->name);

		Yii::app()->setLanguage($model->locale);
		$this->_active = $model->code;
	}

	/**
	 * Get language prefix to create url.
	 * If current language is default prefix will be empty.
	 * @return string Url prefix
	 */
	public function getUrlPrefix()
	{
		if ($this->_active !== $this->_default)
		   return $this->_active;
	}
}
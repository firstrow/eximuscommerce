<?php

class SLanguageManager extends CApplicationComponent {
	
	protected $_languages = array();
	protected $_active;
	protected $_default;

	public function init()
	{
		if (empty($this->_languages))
			$this->loadLanguages();
	}

	/**
	 * Load aviable languages.
	 * @return type
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
     * get lang by its code
     * @param type $langCode 
     * @return SSystemLanguage
     */
    public function getByCode($langCode)
    {
        if (isset($this->_languages[$langCode]))
            return $this->_languages[$langCode];
    }

    /**
     * Get language codes
     * @return array array('en','ru',...)
     */
    public function getCodes()
    {
        return array_keys($this->_languages);        
    }

    public function getDefault()
    {
    	return $this->getByCode($this->_default);
    }

    /**
     * Activate language by code
     * @param type $code Language code.
     */
    public function setActive($code=null)
    {
    	$model = $this->getByCode($code);

    	if (!$model)
    		$model = $this->default;

    	$this->activate($model);
    }

    /**
     * Get active language model
     * @return SSystemLanguage
     */
    public function getActive()
    {
    	return $this->getByCode($this->_active);
    }

    protected function activate(SSystemLanguage $model)
    {
   		Yii::trace('Activating languge '.$model->name);
   		Yii::app()->setLanguage($model->locale);
   		$this->_active = $model->code;	
    }

}
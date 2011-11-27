<?php

class SHttpRequest extends CHttpRequest {

	private $_pathInfo;

	public function init()
	{
		return parent::init();
	}

	/**
	 * @return string Parsed path info without lang prefix.
	 */
	public function getPathInfo()
	{
		$langCode = null;

		if($this->_pathInfo===null)
		{
			$pathInfo = parent::getPathInfo();
	        $parts = explode('/', $pathInfo);

	        if (in_array($parts[0], Yii::app()->languageManager->getCodes()))
	        {
	        	// Vaid language code detected.
	        	// Remove it from url path to make route work and activate lang
	    		$langCode = $parts[0];

	            unset($parts[0]);
	            $pathInfo = implode($parts, '/');
	        }

	        $this->_pathInfo = $pathInfo;
		}

		// Activate language by code
		Yii::app()->languageManager->setActive($langCode);

		return $pathInfo;
	}
	
}
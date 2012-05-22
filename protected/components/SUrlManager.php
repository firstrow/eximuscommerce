<?php

/**
 * Manager urls
 */
class SUrlManager extends CUrlManager {

	/**
	 * Init
	 * @access public
	 */
	public function init()
	{
		$this->_loadModuleUrls();
		parent::init();
	}

	/**
	 * Create url based on current language.
	 * @param mixed $route
	 * @param array $params
	 * @param string $ampersand
	 * @param boolean $respectLang
	 * @access public
	 * @return string
	 */
	public function createUrl($route,  $params=array(),  $ampersand='&', $respectLang = true)
	{
		$result = parent::createUrl($route,$params,$ampersand);

		if ($respectLang === true)
		{
			$langPrefix = Yii::app()->languageManager->getUrlPrefix();
			if ($langPrefix)
				$result = '/'.$langPrefix.$result;
		}

		// Add training slash to urls
//		if('/' !== $result{strlen($result) - 1})
//			$result .= '/';

		return $result;
	}

	/**
	 * Scan each module dir and include routes.php
	 * Add module urls at the beginning of $config['urlManager']['rules']
	 * @access protected
	 */
	protected function _loadModuleUrls()
	{
		$moduleDirs = array();
		$modules = SystemModules::getEnabled();

		foreach($modules as $m)
			array_push($moduleDirs, $m->name);

		$pattern = strtr(':fullPath/{:enabledModules}/config/routes.php', array(
			':fullPath'=>Yii::getPathOfAlias('application.modules'),
			':enabledModules'=>implode(',', $moduleDirs),
		));

		foreach(glob($pattern, GLOB_BRACE) as $route)
			$this->rules = array_merge(require($route), $this->rules);
	}

}

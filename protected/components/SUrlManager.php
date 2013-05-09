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
		$cacheKey = 'url_manager_urls';
		$rules    = Yii::app()->cache->get($cacheKey);

		if(YII_DEBUG || !$rules)
		{
			$moduleDirs = array();
			$modules    = SystemModules::getEnabled();

			foreach($modules as $m)
				array_push($moduleDirs, $m->name);

			$pathParts = array(
				Yii::getPathOfAlias('application.modules'),
				'{'.implode(',', $moduleDirs).'}',
				'config',
				'routes.php'
			);

			$pattern = implode(DIRECTORY_SEPARATOR, $pathParts);

			foreach(glob($pattern, GLOB_BRACE) as $route)
				$rules = array_merge(require($route), $rules);

			Yii::app()->cache->set($cacheKey, $rules, 3600);
		}

		$this->rules = array_merge($rules, $this->rules);
	}

}

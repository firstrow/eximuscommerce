<?php

class SUrlManager extends CUrlManager {

    public $appendLangPrefix = false;

    /**
     * Init 
     * 
     * @access public
     */
    public function init()
    {
        $this->_loadModuleUrls();
        parent::init();
    }

    /**
     * Parse request url to detect current language in first segment. 
     * 
     * @param mixed $request 
     * @access public
     * @return void
     */
    // public function parseUrl($request)
    // {
    //         $result = parent::parseUrl($request);
    //         $parts = explode('/', $result);

    //         if (in_array($parts[0], Yii::app()->params['languages']))
    //         {
    //                 Yii::app()->setLanguage($parts[0]);
    //                 $this->appendLangPrefix = true;
    //                 unset($parts[0]);
    //                 $result = implode($parts, '/');
    //         }

    //         return $result;
    // }

    /**
     * Create url based on current language.
     * 
     * @param mixed $route 
     * @param array $params 
     * @param string $ampersand 
     * @access public
     * @return string
     */
    //public function createUrl($route,  $params=array(),  $ampersand='&')
    //{
    //	$result = parent::createUrl($route,$params,$ampersand);
    //	if ($this->appendLangPrefix === true)
    //		$result = '/'.Yii::app()->language.$result;
    //	return $result;
    //}

    /**
     * Scan each module dir and include routes.php
     * Add module urls at the begining of $config['urlManager']['rules']
     *
	 * TODO: Cache found routes to php file in runtime dir.
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

        foreach (glob($pattern, GLOB_BRACE) as $route)
            $this->rules = array_merge(require($route), $this->rules);
    }

}

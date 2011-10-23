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
	 * TODO: Cache result and use only installed modules.
     * @access protected
     */
    protected function _loadModuleUrls()
    {
        $ruleFiles = glob(Yii::getPathOfAlias('application.modules.*') . '/*/config/routes.php');

        foreach ($ruleFiles as $urlFile)
        {
            $this->rules = array_merge(require($urlFile), $this->rules); 
        }
    }	

}

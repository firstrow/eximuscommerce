<?php

Yii::import('application.modules.pages.models.PageCategory');

/**
 * Route for page categories.
 * @package modules.core
 */
class CategoryUrlRule extends CBaseUrlRule
{
    public $connectionID = 'db';
    public $urlSuffix = '';
 
    public function createUrl($manager,$route,$params,$ampersand)
    {
        if ($route==='pages/pages/list')
        {
            return $params['url'].$this->urlSuffix;
        }
        return false;
    }
 
    public function parseUrl($manager,$request,$pathInfo,$rawPathInfo)
    {
        if ($this->urlSuffix)
            $pathInfo = strtr($pathInfo, array($this->urlSuffix=>''));

        $check = PageCategory::model()
            ->withFullUrl($pathInfo)
            ->count();

        if ($check)
        {
            $_GET['url'] = $pathInfo;
            return 'pages/pages/list';
        }
        return false;
    }
}

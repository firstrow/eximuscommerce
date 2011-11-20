<?php

Yii::import('application.modules.pages.models.PageCategory');

class CategoryUrlRule extends CBaseUrlRule
{
    public $connectionID = 'db';
 
    public function createUrl($manager,$route,$params,$ampersand)
    {
        if ($route==='pages/pages/list')
        {
            return $params['url'];
        }
        return false;
    }
 
    public function parseUrl($manager,$request,$pathInfo,$rawPathInfo)
    {
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

<?php

Yii::import('application.modules.pages.models.PageCategory');

/**
 * Route for page categories.
 * @package modules.core
 */
class CategoryUrlRule extends CBaseUrlRule
{
    public $connectionID = 'db';
    public $urlSuffix    = '';
 
    public function createUrl($manager,$route,$params,$ampersand)
    {
        if($route==='pages/pages/list')
        {
            $url=trim($params['url'],'/');
            unset($params['url']);

            $parts=array();
            if(!empty($params))
            {
                foreach ($params as $key=>$val)
                    $parts[]=$key.'/'.$val;

                $url .= '/'.implode('/', $parts);
            }

            return $url.$this->urlSuffix;;
        }
        return false;
    }
 
    public function parseUrl($manager,$request,$pathInfo,$rawPathInfo)
    {
        if ($this->urlSuffix)
            $pathInfo = strtr($pathInfo, array($this->urlSuffix=>''));

        $parts    = explode('/', $pathInfo);
        $pathInfo = $parts[0];

        if(isset($parts[1], $parts[2]))
        {
            if('page'===$parts[1])
                $_GET['page']=$parts[2];
        }

        if(PageCategory::countByPath($pathInfo))
        {
            $_GET['url'] = $pathInfo;
            return 'pages/pages/list';
        }
        return false;
    }

}

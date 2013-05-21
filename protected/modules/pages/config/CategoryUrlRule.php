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

		if(PageCategory::countByPath($pathInfo))
		{
			$_GET['url'] = $pathInfo;
			return 'pages/pages/list';
		}

		return false;
	}

}

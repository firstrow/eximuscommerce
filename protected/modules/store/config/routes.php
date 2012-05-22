<?php

/**
 * StoreModule routes
 */
return array(
	'product/<url>'=>array('store/frontProduct/view', 'urlSuffix'=>'.html'),
	'product/captcha'=>array('store/frontProduct/captcha'),
	'store/ajax/activateCurrency/<id>'=>array('store/ajax/activateCurrency'),
	'store/index/renderProductsBlock/<scope>'=>array('store/index/renderProductsBlock'),
	array('store/category/view', 'pattern'=>'category/<url>/*'),
	'products/search/*'=>array('store/category/search'),
	'products/compare'=>array('store/compare/index'),
	'products/compare/add/<id>'=>array('store/compare/add'),
	'products/compare/remove/<id>'=>array('store/compare/remove'),
	//	'category/<url>/*'=>array'store/category/view',
	//'store/frontProduct/*'=>'site/error',
	'store/index'=>'site/error',
	'store/compare'=>'site/error',
);
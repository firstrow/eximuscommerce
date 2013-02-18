<?php

/**
 * StoreModule routes
 */
return array(
	'product/<url>'=>array('store/frontProduct/view', 'urlSuffix'=>'.html'),
	'product/captcha'=>array('store/frontProduct/captcha'),
	'store/ajax/activateCurrency/<id>'=>array('store/ajax/activateCurrency'),
	'store/ajax/rateProduct/<id>'=>array('store/ajax/rateProduct'),
	'store/index/renderProductsBlock/<scope>'=>array('store/index/renderProductsBlock'),
	array('store/category/view', 'pattern'=>'category/<url>/*'),
	'products/search/*'=>array('store/category/search'),
	// Compare
	'products/compare'=>array('store/compare/index'),
	'products/compare/add/<id>'=>array('store/compare/add'),
	'products/compare/remove/<id>'=>array('store/compare/remove'),
	// WishList
	'wishlist'=>array('store/wishlist/index'),
	'wishlist/add/<id>'=>array('store/wishlist/add'),
	'wishlist/remove/<id>'=>array('store/wishlist/remove'),
	'wishlist/view/<key>'=>array('store/wishlist/view'),
	//	'category/<url>/*'=>array'store/category/view',
	//'store/frontProduct/*'=>'site/error',
	'store/index'=>'site/error',
	'store/compare'=>'site/error',
	'store/wishlist'=>'site/error',
	'manufacturer/<url>'=>array('/store/manufacturer/index'),
);
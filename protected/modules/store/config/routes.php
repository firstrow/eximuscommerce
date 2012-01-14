<?php

/**
 * StoreModule routes
 */

return array(
	'product/<url>'=>array('store/frontProduct/view', 'urlSuffix'=>'.html'),
	array('store/category/view', 'pattern'=>'category/<url>/*'),
	//'category/<url>/*'=>array'store/category/view',
	//'store/frontProduct/*'=>'site/error',
);
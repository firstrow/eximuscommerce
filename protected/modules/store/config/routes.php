<?php

/**
 * StoreModule routes
 */

return array(
	'product/<url>'=>array('store/frontProduct/view', 'urlSuffix'=>'.html'),
	'category/'=>'store/category/view',
	//'store/frontProduct/*'=>'site/error',
);
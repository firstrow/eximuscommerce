<?php

/**
 * StoreModule routes
 */

return array(
    'product/<url>'=>array('store/frontProduct/view', 'urlSuffix'=>'.html'),
    'store/frontProduct/*'=>'site/error',
);
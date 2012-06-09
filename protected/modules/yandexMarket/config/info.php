<?php

Yii::import('application.modules.yandexMarket.YandexMarketModule');

/**
 * Module info
 */ 
return array(
	'name'        => Yii::t('YandexMarketModule.core', 'Yandex.Market.'),
	'author'      => 'firstrow@gmail.com',
	'version'     => '0.1',
	'config_url'  => Yii::app()->createUrl('/yandexMarket/admin/default'),
	'description' => Yii::t('YandexMarketModule.core', 'Экспорт товаров в Yandex.Market в формате YML.'),
	'url'         => '',
);
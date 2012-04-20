<?php

Yii::import('application.modules.csv.CsvModule');

/**
 * Module info
 */
return array(
    'name'        => Yii::t('CsvModule.admin', 'CSV'),
    'author'      => 'firstrow@gmail.com',
    'version'     => '0.1',
    'description' => Yii::t('CsvModule.admin', 'Импорт/экспорт товаров, категорий, свойств в формате CSV.'),
    'url'         => '', # Url to module home page.
);
<?php

/**
 * Import
 */

$this->pageHeader = Yii::t('CsvModule.core', 'Импорт');

$this->breadcrumbs = array(
	'Home'=>$this->createUrl('/admin'),
	Yii::t('CsvModule.admin', 'Модули')=>Yii::app()->createUrl('/core/admin/systemModules'),
	Yii::t('CsvModule.admin', 'Импорт')
);

?>
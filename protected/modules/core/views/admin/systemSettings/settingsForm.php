<?php

$themes=Yii::app()->themeManager->themeNames;
$themes=array_combine($themes, $themes);

return array(
	'id'=>'systemSettingsForm',
	'showErrorSummary'=>true,
	'elements'=>array(
		'siteName'=>array('type'=>'text'),
		'productsPerPage'=>array(
			'type'=>'text',
			'hint'=>Yii::t('CoreModule.admin', 'Вы можете указать несколько значений разделяя их запятой. Например: 10,20,30'),
		),
		'productsPerPageAdmin'=>array('type'=>'text'),
		'theme'=>array(
			'type'=>'dropdownlist',
			'items'=>$themes
		),
	)
);
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
		'	<div class="row">
			<label>&nbsp;</label>
			<h3>Настройки WYSIWYG редактора</h3>
			</div>
		',
		'editorTheme'=>array(
			'type'=>'dropdownlist',
			'items'=>array(
				'compant'  => Yii::t('CoreModule.admin', 'Компактная'),
				'normal'   => Yii::t('CoreModule.admin', 'Стандартная'),
				'complete' => Yii::t('CoreModule.admin', 'Полная'),
				'maxi'     => Yii::t('CoreModule.admin', 'Максимальная')
			)
		),
		'editorHeight'=>array('type'=>'text'),
		'editorAutoload'=>array('type'=>'checkbox'),
	)
);
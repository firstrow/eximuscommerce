<?php

$themes=Yii::app()->themeManager->themeNames;
$themes=array_combine($themes, $themes);

return array(
	'id'=>'systemSettingsForm',
	'showErrorSummary'=>true,
	'elements'=>array(
		'main'=>array(
			'type'=>'form',
			'title'=>Yii::t('CoreModule.admin', 'Настройки'),
			'elements'=>array(
				'core_siteName'=>array('type'=>'text'),
				'core_productsPerPage'=>array(
					'type'=>'text',
					'hint'=>Yii::t('CoreModule.admin', 'Вы можете указать несколько значений разделяя их запятой. Например: 10,20,30'),
				),
				'core_productsPerPageAdmin'=>array('type'=>'text'),
				'core_theme'=>array(
					'type'=>'dropdownlist',
					'items'=>$themes
				),
				'	<div class="row">
					<label>&nbsp;</label>
					<h3>Настройки WYSIWYG редактора</h3>
					</div>
				',
				'core_editorTheme'=>array(
					'type'=>'dropdownlist',
					'items'=>array(
						'compant'  => Yii::t('CoreModule.admin', 'Компактная'),
						'normal'   => Yii::t('CoreModule.admin', 'Стандартная'),
						'complete' => Yii::t('CoreModule.admin', 'Полная'),
						'maxi'     => Yii::t('CoreModule.admin', 'Максимальная')
					)
				),
				'core_editorHeight'=>array('type'=>'text'),
				'core_editorAutoload'=>array('type'=>'checkbox'),
			)
		),
		'images'=>array(
			'type'     => 'form',
			'title'    => Yii::t('CoreModule.admin', 'Изображения'),
			'elements' => array(
				'images_path'               => array('type'=>'text'),
				'images_thumbPath'          => array('type'=>'text'),
				'images_url'                => array('type'=>'text'),
				'images_thumbUrl'           => array('type'=>'text'),
				'images_maxFileSize'        => array(
					'type'=>'text',
					'hint'=>Yii::t('CoreModule.admin', 'Укажите размер в байтах.')
				),
				'images_maximum_image_size' => array(
					'type'=>'text',
					'hint'=>Yii::t('CoreModule.admin', 'Изображения превышающие этот размер, будут изменены.')
				),
			)
		)
	)
);
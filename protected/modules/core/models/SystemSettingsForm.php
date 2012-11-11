<?php

class SystemSettingsForm extends CFormModel
{

	/**
	 * @var string
	 */
	public $siteName;

	/**
	 * @var integer products limit to display on front site
	 */
	public $productsPerPage;

	/**
	 * @var integer
	 */
	public $productsPerPageAdmin;

	/**
	 * @var string site theme name
	 */
	public $theme;

	/**
	 * Editor settings
	 */
	public $editorTheme;
	public $editorHeight;
	public $editorAutoload;

	public function init()
	{
		$this->attributes=Yii::app()->settings->get('core');
	}
	/**
	 * @return array
	 */
	public function rules()
	{
		return array(
			array('siteName, productsPerPage, productsPerPageAdmin, theme, editorTheme, editorHeight, editorAutoload', 'required'),
		);
	}

	/**
	 * @return array
	 */
	public function attributeLabels()
	{
		return array(
			'siteName'            => Yii::t('CoreModule.admin', 'Название сайта'),
			'productsPerPage'     => Yii::t('CoreModule.admin', 'Количество товаров на сайте'),
			'productsPerPageAdmin'=> Yii::t('CoreModule.admin', 'Количество товаров в панели управления'),
			'theme'               => Yii::t('CoreModule.admin', 'Тема'),
			// Editor
			'editorTheme'         => Yii::t('CoreModule.admin', 'Тема'),
			'editorHeight'        => Yii::t('CoreModule.admin', 'Высота'),
			'editorAutoload'      => Yii::t('CoreModule.admin', 'Автоматическая активация'),
		);
	}

	/**
	 * Saves attributes into database
	 */
	public function save()
	{
		Yii::app()->settings->set('core', $this->attributes);
	}
}

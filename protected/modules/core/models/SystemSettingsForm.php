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
			array('siteName, productsPerPage, productsPerPageAdmin', 'required'),
		);
	}

	/**
	 * @return array
	 */
	public function attributeLabels()
	{
		return array(
			'siteName'            =>Yii::t('CoreModule.admin', 'Название сайта'),
			'productsPerPage'     =>Yii::t('CoreModule.admin', 'Количество товаров на сайте'),
			'productsPerPageAdmin'=>Yii::t('CoreModule.admin', 'Количество товаров в панели управления'),
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

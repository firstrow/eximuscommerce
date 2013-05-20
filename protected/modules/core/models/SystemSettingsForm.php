<?php

class SystemSettingsForm extends CFormModel
{

	/**
	 * @var string
	 */
	public $core_siteName;

	/**
	 * @var integer products limit to display on front site
	 */
	public $core_productsPerPage;

	/**
	 * @var integer
	 */
	public $core_productsPerPageAdmin;

	/**
	 * @var string site theme name
	 */
	public $core_theme;

	/**
	 * Editor settings
	 */
	public $core_editorTheme;
	public $core_editorHeight;
	public $core_editorAutoload;

	/**
	 * Image settings
	 */
	public $images_path;
	public $images_thumbPath;
	public $images_url;
	public $images_thumbUrl;
	public $images_maxFileSize;
	public $images_maximum_image_size;

	public function init()
	{
		$categories = array('core', 'images');

		foreach ($categories as $c)
		{
			$settings=Yii::app()->settings->get($c);

			if($settings)
			{
				foreach ($settings as $key=>$val)
				{
					$attr = $c.'_'.$key;
					if(property_exists($this, $attr))
						$this->$attr = $val;
				}
			}
		}

	}
	/**
	 * @return array
	 */
	public function rules()
	{
		return array(
			array('core_siteName, core_productsPerPage, core_productsPerPageAdmin, core_theme, core_editorTheme, core_editorHeight, core_editorAutoload', 'required'),
			array('images_path, images_thumbPath, images_url, images_thumbUrl, images_maxFileSize, images_maximum_image_size', 'required'),
		);
	}

	/**
	 * @return array
	 */
	public function attributeLabels()
	{
		return array(
			'core_siteName'            => Yii::t('CoreModule.admin', 'Название сайта'),
			'core_productsPerPage'     => Yii::t('CoreModule.admin', 'Количество товаров на сайте'),
			'core_productsPerPageAdmin'=> Yii::t('CoreModule.admin', 'Количество товаров в панели управления'),
			'core_theme'               => Yii::t('CoreModule.admin', 'Тема'),
			// Editor
			'core_editorTheme'         => Yii::t('CoreModule.admin', 'Тема'),
			'core_editorHeight'        => Yii::t('CoreModule.admin', 'Высота'),
			'core_editorAutoload'      => Yii::t('CoreModule.admin', 'Автоматическая активация'),
			// Images
			'images_path'              => Yii::t('CoreModule.admin', 'Путь сохранения'),
			'images_thumbPath'         => Yii::t('CoreModule.admin', 'Путь к превью'),
			'images_url'               => Yii::t('CoreModule.admin', 'Ссылка к изображениям'),
			'images_thumbUrl'          => Yii::t('CoreModule.admin', 'Ссылка к превью'),
			'images_maxFileSize'       => Yii::t('CoreModule.admin', 'Максимальный размер файла'),
			'images_maximum_image_size'=> Yii::t('CoreModule.admin', 'Максимальный размер изображения'),
		);
	}

	/**
	 * Saves attributes into database
	 */
	public function save()
	{
		Yii::app()->settings->set('core', $this->getDataByPrefix('core'));
		Yii::app()->settings->set('images', $this->getDataByPrefix('images'));
	}

	public function getDataByPrefix($prefix)
	{
		$prefix.='_';
		$result = array();

		foreach ($this->attributes as $key=>$val)
		{
			if(substr($key,0,strlen($prefix))===$prefix)
			{
				$k=substr($key,strlen($prefix));
				$result[$k]=$val;
			}
		}

		return $result;
	}
}

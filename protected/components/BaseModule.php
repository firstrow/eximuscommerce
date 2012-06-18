<?php

/**
 * Base admin module 
 * 
 * @uses CWebModule
 * @package Admin
 * @version $id$
 */
class BaseModule extends CWebModule {

	public $_assetsUrl = null;

	public function initAdmin()
	{
		$this->setImport(array(
			'admin.models.*',
			'admin.components.*',
			'admin.widgets.*',
		));
	}

	/**
	 * Publish admin stylesheets,images,scripts,etc.. and return assets url
	 *
	 * @access public
	 * @return string Assets url
	 */
	public function getAssetsUrl()
	{
		if($this->_assetsUrl===null)
		{
			$this->_assetsUrl=Yii::app()->getAssetManager()->publish(
				Yii::getPathOfAlias('application.modules.'.$this->moduleName.'.assets'),
				false,
				-1,
				YII_DEBUG
			);
		}

		return $this->_assetsUrl;
	}

	/**
	 * Set assets url
	 *
	 * @param string $url
	 * @access public
	 * @return void
	 */
	public function setAssetsUrl($url)
	{
		$this->_assetsUrl = $url;
	}

	/**
	 * Method will be called after module installed
	 */
	public function afterInstall()
	{}

	/**
	 * Method will be called after module removed
	 */
	public function afterRemove()
	{}
}

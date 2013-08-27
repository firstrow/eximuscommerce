<?php

class StoreImagesConfig
{
	public static $initialized  = false;
	public static $settings_key = 'images';
	public static $db_settings  = null;

	/**
	 * @var array.
	 */
	public static $defaults = array(
			// Overrided from db
			'path'               => 'webroot.uploads.product',
			'thumbPath'          => 'webroot.assets.productThumbs',
			'url'                => '/uploads/product/', // With ending slash
			'thumbUrl'           => '/assets/productThumbs/', // With ending slash
			'maxFileSize'        => 10485760, //10*1024*1024,
			'maximum_image_size' => '800x600',
			// Not overrided
			'extensions'         => array('jpg', 'jpeg','png', 'gif'),
			'types'              => array('image/gif','image/jpeg', 'image/pjpeg', 'image/png',  'image/x-png'),
			'resizeMethod'       =>'resize', // resize/adaptiveResize
			'resizeThumbMethod'  =>'resize', // resize/adaptiveResize
			'watermark_active'   => 0,
			'watermark_opacity'  => 1,
		);

	/**
	 * Initialize component
	 */
	public static function initialize()
	{
		self::$initialized = true;

		if(isset(Yii::app()->settings) && Yii::app()->settings instanceof SSystemSettings)
			self::$db_settings = Yii::app()->settings->get(self::$settings_key);
		else
			self::$db_settings = self::$defaults;
	}

	/**
	 * Get config value by key
	 *
	 * @param $key
	 * @return mixed
	 * @throws CException
	 */
	public static function get($key)
	{
		if(!self::$initialized)
			self::initialize();

		if(array_key_exists($key, self::$db_settings))
		{
			if('maximum_image_size'===$key)
				return explode('x', self::$db_settings[$key]);
			return self::$db_settings[$key];
		}
		elseif(array_key_exists($key, self::$defaults))
		{
			if('maximum_image_size'===$key)
				return explode('x', self::$defaults[$key]);
			return self::$defaults[$key];
		}
		else
			throw new CException('Unsupported key '.$key, 503);
	}

}
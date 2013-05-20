<?php

Yii::import('application.modules.store.components.StoreImagesConfig');

/**
 * Validate uploaded product image.
 * Create unique image name.
 */
class StoreUploadedImage
{

	/**
	 * @param CUploadedFile $image
	 * @return bool
	 */
	public static function isAllowedSize(CUploadedFile $image)
	{
		return ($image->getSize() <= StoreImagesConfig::get('maxFileSize'));
	}

	/**
	 * @param CUploadedFile $image
	 * @return bool
	 */
	public static function isAllowedExt(CUploadedFile $image)
	{
		return in_array(strtolower($image->getExtensionName()),  StoreImagesConfig::get('extensions'));
	}

	/**
	 * @param CUploadedFile $image
	 * @return bool
	 */
	public static function isAllowedType(CUploadedFile $image)
	{
		$type = CFileHelper::getMimeType($image->getTempName());
		if(!$type)
			$type = CFileHelper::getMimeTypeByExtension($image->getName());
		return in_array($type,  StoreImagesConfig::get('types'));
	}

	/**
	 * @param CUploadedFile $image
	 * @return bool
	 */
	public static function hasErrors(CUploadedFile $image)
	{
		return !(!$image->getError() && self::isAllowedExt($image) === true && self::isAllowedSize($image) === true && self::isAllowedType($image) === true);
	}

	/**
	 * @return string Path to save product image
	 */
	public static function getSavePath()
	{
		return Yii::getPathOfAlias(StoreImagesConfig::get('path'));
	}

	/**
	 * @param StoreProduct $model
	 * @param CUploadedFile $image
	 * @return string
	 */
	public static function createName(StoreProduct $model, CUploadedFile $image)
	{
		$path = self::getSavePath();
		$name = self::generateRandomName($model, $image);

		if (!file_exists($path.'/'.$name))
			return $name;
		else
			self::createName($model, $image);
	}

	/**
	 * Generates random name bases on product and image models
	 *
	 * @param StoreProduct $model
	 * @param CUploadedFile $image
	 * @return string
	 */
	public static function generateRandomName(StoreProduct $model, CUploadedFile $image)
	{
		return strtolower($model->id.'_'.crc32(microtime()).'.'.$image->getExtensionName());
	}

}
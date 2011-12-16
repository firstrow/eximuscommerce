<?php

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
        return ($image->getSize() <= Yii::app()->params['storeImages']['maxFileSize']);
    }

    /**
     * @param CUploadedFile $image
     * @return bool
     */
    public static function isAllowedExt(CUploadedFile $image)
    {
        return in_array($image->getExtensionName(), Yii::app()->params['storeImages']['extensions']);
    }

    /**
     * @param CUploadedFile $image
     * @return bool
     */
    public static function isAllowedType(CUploadedFile $image)
    {
        return in_array($image->getType(), Yii::app()->params['storeImages']['types']);
    }

    /**
     * @param CUploadedFile $image
     * @return bool
     */
    public static function hasErrors(CUploadedFile $image)
    {
        return (!$image->getError() && self::isAllowedExt($image) && self::isAllowedSize($image) && self::isAllowedType($image));
    }

    /**
     * @return string Path to save product image
     */
    public static function getSavePath()
    {
        return Yii::getPathOfAlias(Yii::app()->params['storeImages']['path']);
    }

    /**
     * @param StoreProduct $model
     * @param CUploadedFile $image
     * @return string
     */
    public static function createName(StoreProduct $model, CUploadedFile $image)
    {
        $path = self::getSavePath();
        $name = strtolower($model->id.'.'.$image->getExtensionName());

        if (!file_exists($path.'/'.$name))
            return $name;
        else
            return strtolower($model->id.'_'.md5(microtime()).'.'.$image->getExtensionName());
    }

}
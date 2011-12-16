<?php

class StoreUploadedImage
{

    public function isAllowedSize($image)
    {
        return ($image->getSize() <= Yii::app()->params['storeImages']['maxFileSize']);
    }

    public function isAllowedExt($image)
    {
        return in_array($image->getExtensionName(), Yii::app()->params['storeImages']['extensions']);
    }

    public function isAllowedType($image)
    {
        return in_array($image->getType(), Yii::app()->params['storeImages']['types']);
    }

    public function hasErrors($image)
    {
        return (!$image->getError() && self::isAllowedExt($image) && self::isAllowedSize($image) && self::isAllowedType($image));
    }

    public function createName(StoreProduct $model, CUploadedFile $image)
    {
        return strtolower($model->id.'.'.$image->getExtensionName());
    }

}
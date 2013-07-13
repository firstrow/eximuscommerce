<?php

Yii::import('application.modules.store.components.StoreImagesConfig');

/**
 * This is the model class for table "StoreProductImage".
 *
 * The followings are the available columns in table 'StoreProductImage':
 * @property integer $id
 * @property integer $product_id
 * @property string $name
 * @property integer $is_main
 * @property integer $uploaded_by
 * @property string $date_uploaded
 * @property string $title
 */
class StoreProductImage extends BaseModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return StoreProductImage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'StoreProductImage';
	}

	/**
	 * @return array
	 */
	public function relations()
	{
		return array(
			'author'=>array(self::BELONGS_TO, 'User', 'uploaded_by'),
		);
	}

	/**
	 * @return array
	 */
	public function defaultScope()
	{
		return array(
			'order'=>'date_uploaded DESC',
		);
	}

	/**
	 * Get url to product image. Enter $size to resize image.
	 * @param mixed $size New size of the image. e.g. '150x150'
	 * @param mixed $resizeMethod Resize method name to override config. resize/adaptiveResize
	 * @param mixed $random Add random number to the end of the string
	 * @return string
	 */
	public function getUrl($size = false, $resizeMethod = false, $random = false)
	{
		if($size !== false)
		{
			$thumbPath = Yii::getPathOfAlias(StoreImagesConfig::get('thumbPath')).'/'.$size;
			if(!file_exists($thumbPath))
				mkdir($thumbPath);

			// Path to source image
			$fullPath  = Yii::getPathOfAlias(StoreImagesConfig::get('path')).'/'.$this->name;
			// Path to thumb
			$thumbPath = $thumbPath.'/'.$this->name;

			if(!file_exists($thumbPath))
			{
				// Resize if needed
				Yii::import('ext.phpthumb.PhpThumbFactory');
				$sizes  = explode('x', $size);
				$thumb  = PhpThumbFactory::create($fullPath);

				if($resizeMethod === false)
					$resizeMethod = StoreImagesConfig::get('resizeThumbMethod');
				$thumb->$resizeMethod($sizes[0],$sizes[1])->save($thumbPath);
			}

			return StoreImagesConfig::get('thumbUrl').$size.'/'.$this->name;
		}

		if ($random === true)
			return StoreImagesConfig::get('url').$this->name.'?'.rand(1, 10000);
		return StoreImagesConfig::get('url').$this->name;
	}

	public function attributeLabels()
	{
		return array(
			'product_id'    => Yii::t('StoreModule.admin', 'Продукт'),
			'name'          => Yii::t('StoreModule.admin', 'Имя файла'),
			'is_main'       => Yii::t('StoreModule.admin', 'Главное'),
			'author'        => Yii::t('StoreModule.admin', 'Автор'),
			'uploaded_by'   => Yii::t('StoreModule.admin', 'Автор'),
			'date_uploaded' => Yii::t('StoreModule.admin', 'Дата загрузки'),
			'title'         => Yii::t('StoreModule.admin', 'Название'),
		);
	}

	/**
	 * Delete file, etc...
	 */
	public function afterDelete()
	{
		// Delete file
		if (file_exists($this->filePath))
			unlink($this->filePath);

		// If main image was deleted
		if ($this->is_main)
		{
			// Get first image and set it as main
			$model = StoreProductImage::model()->find();
			if ($model)
			{
				$model->is_main = 1;
				$model->save(false);
			}
		}

		return parent::afterDelete();
	}

	/**
	 * @return string
	 *
	 */
	public function getFilePath()
	{
		return Yii::getPathOfAlias(StoreImagesConfig::get('path')).'/'.$this->name;
	}

}
<?php

Yii::import('application.modules.store.models.*');

class SProductsDuplicator extends CComponent
{

	/**
	 * @var array
	 */
	private $_ids;

	/**
	 * @var array
	 */
	private $duplicate;

	/**
	 * @var string to be appended to the end of product name
	 */
	private $_suffix;

	public function __construct()
	{
		$this->_suffix = ' ('.Yii::t('StoreModule.admin', 'копия').')';
	}

	/**
	 * Creates copy of many products.
	 *
	 * @param array $ids of products to make copy
	 * @param array $duplicate list of product parts to copy: images, variants, etc...
	 * @return array of new product ids
	 */
	public function createCopy(array $ids, array $duplicate=array())
	{
		$this->duplicate = $duplicate;
		$new_ids         = array();

		foreach($ids as $id)
		{
			$model = StoreProduct::model()->findByPk($id);

			if($model)
				$new_ids[] = $this->duplicateProduct($model)->id;
		}

		return $new_ids;
	}

	/**
	 * Duplicate one product and return model
	 *
	 * @param StoreProduct $model
	 * @return StoreProduct
	 */
	public function duplicateProduct(StoreProduct $model)
	{
		$product = new StoreProduct;
		$product->attributes = $model->attributes;

		$behaviors = $model->behaviors();

		foreach ($behaviors['STranslateBehavior']['translateAttributes'] as $attr)
			$product->$attr = $model->$attr;

		$product->name .= $this->getSuffix();

		if($product->save())
		{
			foreach ($this->duplicate as $feature)
			{
				$method_name = 'copy'.ucfirst($feature);

				if(method_exists($this, $method_name))
					$this->$method_name($model, $product);
			}

			return $product;
		}
		else
			return false;
	}

	/**
	 * Creates copy of product images
	 *
	 * @param StoreProduct $original
	 * @param StoreProduct $copy
	 */
	protected function copyImages(StoreProduct $original, StoreProduct $copy)
	{
		$images = $original->images;

		if(!empty($images))
		{
			foreach($images as $image)
			{
				$image_copy = new StoreProductImage();
				$image_copy->product_id    = $copy->id;
				$image_copy->name          = $image->name.'_'.$copy->id;
				$image_copy->is_main       = $image->is_main;
				$image_copy->uploaded_by   = $image->uploaded_by;
				$image_copy->title         = $image->title;
				$image_copy->date_uploaded = date('Y-m-d H:i:s');

				if($image_copy->save())
					copy($image->filePath, $image_copy->filePath);
			}
		}
	}

	/**
	 * Creates copy of EAV attributes
	 *
	 * @param StoreProduct $original
	 * @param StoreProduct $copy
	 */
	protected function copyAttributes(StoreProduct $original, StoreProduct $copy)
	{
		$attributes = $original->getEavAttributes();

		if(!empty($attributes))
		{
			foreach ($attributes as $key=>$val)
			{
				Yii::app()->db->createCommand()->insert('StoreProductAttributeEAV', array(
					'entity'    => $copy->id,
					'attribute' => $key,
					'value'     => $val
				));
			}
		}
	}

	/**
	 * Copy related products
	 *
	 * @param StoreProduct $original
	 * @param StoreProduct $copy
	 */
	protected function copyRelated(StoreProduct $original, StoreProduct $copy)
	{
		$related = $original->related;

		if(!empty($related))
		{
			foreach ($related as $p)
			{
				$model = new StoreRelatedProduct();
				$model->product_id = $copy->id;
				$model->related_id = $p->related_id;
				$model->save();
			}
		}
	}

	/**
	 * Copy product variants
	 *
	 * @param StoreProduct $original
	 * @param StoreProduct $copy
	 */
	public function copyVariants(StoreProduct $original, StoreProduct $copy)
	{
		$variants = $original->variants;

		if(!empty($variants))
		{
			foreach($variants as $v)
			{
				$record = new StoreProductVariant();
				$record->product_id   = $copy->id;
				$record->attribute_id = $v->attribute_id;
				$record->option_id    = $v->option_id;
				$record->price        = $v->price;
				$record->price_type   = $v->price_type;
				$record->sku          = $v->sku;
				$record->save() ;
			}
		}
	}

	/**
	 * @param $str string product suffix
	 */
	public function setSuffix($str)
	{
		$this->_suffix = $str;
	}

	/**
	 * @return string
	 */
	public function getSuffix()
	{
		return $this->_suffix;
	}
}
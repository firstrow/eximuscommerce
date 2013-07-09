<?php

Yii::import('application.modules.store.models.StoreProduct');

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
	 * @var array of features to copy
	 */
	public $available_features = array('images', 'attributes', 'variants', 'related_products');

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
	 */
	public function createCopy(array $ids, array $duplicate=array())
	{
		$this->duplicate = $duplicate;

		foreach($ids as $id)
		{
			$model = StoreProduct::model()->findByPk($id);

			if($model)
				$this->duplicateProduct($model);
		}
	}

	/**
	 * Duplicate one product and return model
	 *
	 * @param StoreProduct $model
	 * @param array $features
	 * @return bool|StoreProduct
	 */
	public function duplicateProduct(StoreProduct $model, array $features = array())
	{
		$product = new StoreProduct;
		$product->attributes = $model->attributes;

		$behaviors = $model->behaviors();

		foreach ($behaviors['STranslateBehavior']['translateAttributes'] as $attr)
			$product->$attr = $model->$attr;

		$product->name .= $this->getSuffix();

		if($product->save())
		{
			foreach ($features as $feature)
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
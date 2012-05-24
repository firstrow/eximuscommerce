<?php

/**
 * Unit tests for SWishlist class
 */
class SWishlistUnitTest extends CTestCase
{

	public function testSWishlist()
	{
		Yii::import('application.modules.store.components.SWishList');
		$product=StoreProduct::model()->active()->find();
		$user=User::model()->find();

		$this->assertTrue($user instanceof User);
		$this->assertTrue($product instanceof $product);

		$model=new SWishList($user->id);

		$this->assertTrue(is_array($model->getIds()));

		// Add right product if
		$this->assertTrue($model->add($product->id));
		// Add wrong product id
		$this->assertFalse($model->add(time()));
		// Check if product added
		$this->assertNotEmpty($model->getIds());
		$this->assertTrue($model->count() >=  1);
		// Check products loading and we have at least one product
		$products=$model->getProducts();
		$this->assertNotEmpty($products);
		$this->assertTrue($products[0] instanceof StoreProduct);
		// Clear all
		$model->clear();
		$this->assertEmpty($model->getIds());
		// Removing
		$this->assertTrue($model->add($product->id));
		$model->remove($product->id);
		$this->assertEmpty($model->getIds());
	}

}

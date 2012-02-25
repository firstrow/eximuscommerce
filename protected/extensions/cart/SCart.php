<?php

/**
 * Product cart
 */
class SCart extends CComponent
{
	/**
	 * List of products added to cart.
	 * Sample data:
	 * 'product_id'=>array(
	 *      'variants'=>array(StoreProductVariant_id)
	 *      'configurable_id'=>2 // Id of configurable product or false.
	 *      'quantity'=>3,
	 *      'price'=>123, // Price of one item
	 * )
	 * @var array
	 */
	private $_items = array();

	public function init()
	{

	}

	public function add()
	{

	}

	public function remove()
	{

	}

	public function clear()
	{

	}

	public function getTotalPrice()
	{

	}

	public function countItems()
	{

	}
}

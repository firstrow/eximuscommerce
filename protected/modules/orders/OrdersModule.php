<?php

/**
 * Order module.
 */
class OrdersModule extends BaseModule
{
	public $moduleName = 'orders';

	/**
	 * Init module
	 */
	public function init()
	{
		$this->setImport(array(
			'orders.models.*'
		));
	}
}

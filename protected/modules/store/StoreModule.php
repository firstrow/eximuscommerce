<?php

class StoreModule extends BaseModule
{
	public $moduleName = 'store';

	public function init()
	{
		$this->setImport(array(
			'store.models.*',
			'store.components.*'
		));
	}
}

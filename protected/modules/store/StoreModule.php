<?php

class StoreModule extends BaseModule
{
	public $moduleName = 'store';

	public function init()
	{
		$this->setImport(array(
			'application.modules.store.models.*',
			'application.modules.store.components.*'
		));
	}
}

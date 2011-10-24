<?php

class PagesModule extends BaseModule 
{
	public $moduleName = 'pages';

	public function init()
	{
		$this->setImport(array(
			'application.modules.pages.models.Page',
		));
	}
}
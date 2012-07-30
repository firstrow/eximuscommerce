<?php

/**
 * Main application class.
 * @package app.components
 */
class SWebApplication extends CWebApplication
{
	public function __construct($config=null)
	{
		parent::__construct($config);
	}

	public function init()
	{
		$this->setSystemModules();
		parent::init();
	}

	/**
	 * Set enabled system modules to enable url access.
	 */
	protected function setSystemModules()
	{
		// Enable installed modules
		$modules = SystemModules::getEnabled();

		if ($modules)
		{
			foreach ($modules as $module)
				$this->setModules(array($module->name));
		}
	}

}
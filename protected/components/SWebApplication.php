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
        register_shutdown_function(array($this, 'shutdown'));
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

    public function shutdown()
    {
        if (YII_ENABLE_ERROR_HANDLER && ($error = error_get_last())) {
            $this->handleError($error['type'], $error['message'], $error['file'], $error['line']);
            die();
        }
    }
}
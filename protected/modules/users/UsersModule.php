<?php

class UsersModule extends BaseModule
{

    public $moduleName = 'users';

    public function init()
    {
        $this->setImport(array(
            'users.models.*',
        ));

        parent::init();
    }

    /**
     * Init admin-level models, componentes, etc...
     * @return type
     */
    public function initAdmin()
    {
        parent::initAdmin();
    }

}

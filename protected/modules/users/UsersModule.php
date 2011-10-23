<?php

class UsersModule extends BaseModule
{

    public $moduleName = 'users';

    public function init()
    {
        Yii::trace('Loaded "users" module.'); 

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
        Yii::trace('Init users module admin resources.'); 
        parent::initAdmin();
    }

}

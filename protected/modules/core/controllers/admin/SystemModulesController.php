<?php

class SystemModulesController extends SAdminController
{
    public function actionIndex()
    {
    	$model = new SystemModules('search');

        if (!empty($_GET['SystemModules']))
            $model->attributes = $_GET['SystemModules'];

        $this->render('index', array(
	    	'model'=>$model,
	    ));
    }

    /**
     * View module details.
     */
    public function actionView()
    {
        $this->render('view');
    }

    /**
     * Display list of modules aviable to install.
     * @return type
     */
    public function actionInstall($name=null)
    {
        if ($name)
        {
            $result = SystemModules::install($name);
            if ($result)
                $this->setFlashMessage(Yii::t('CoreModule.core', 'Модуль успешно установлен.'));
            else
                $this->setFlashMessage(Yii::t('CoreModule.core', 'Возникла ошибка при установке модуля.'));

            $this->redirect('index');
        }

        $this->render('install', array(
            'modules'=>SystemModules::getAviable(),
        ));
    }

    /**
     * Delete module by Pk
     * TODO: Reise module beforeDelete event
     */
    public function actionDelete()
    {
        if (Yii::app()->request->isPostRequest)
        {
            $model = SystemModules::model()->findByPk($_GET['id']);

            if ($model)
                $model->delete();

            if (!Yii::app()->request->isAjaxRequest)
                $this->redirect('index');
        }
    }
    
}
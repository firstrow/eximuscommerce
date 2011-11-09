<?php

class GridViewController extends SAdminController
{

    public function filters() {
        return array(
            'ajaxOnly + saveFilterData',
        );
    }

    public function actionSaveFilterData()
    {
        Yii::import('application.modules.core.models.GridViewFilter');
        $model = new GridViewFilter;
        $model->user_id = Yii::app()->user->id;
        $model->grid_id = $_POST['gridId'];
        $model->name = $_POST['filterName'];
        $model->data = $_POST['filterJsonData'];

        if ($model->validate())
            $model->save();
        else
            echo 'Error';
    }
 
}
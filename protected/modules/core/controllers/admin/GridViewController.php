<?php

class GridViewController extends SAdminController
{

    public function filters() {
        return array(
            'ajaxOnly + saveFilterData',
        );
    }

    /**
     * Save personal user filter.
     */
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

    public function actionLoadFilterJsonData($id)
    {
        $model = $this->_loadModel($id);

        if ($model)
            echo $model->data;
    }
 
    public function actionDeleteFilter($id, $redirect)
    {
        $model = $this->_loadModel($id);

        if ($model)
            $model->delete();
            
        $this->redirect(base64_decode($redirect));
    }

    protected function _loadModel($id)
    {
        return GridViewFilter::model()->findByAttributes(array(
            'user_id'=>Yii::app()->user->id,
            'id'=>$id
        ));
    }
}
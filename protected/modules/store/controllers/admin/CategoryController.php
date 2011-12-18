<?php

/**
 * Admin product category controller
 */
class CategoryController extends SAdminController {

    public function actionIndex()
    {
        $model = new CArrayDataProvider(StoreCategory::model()->findAll(array('order'=>'lft')), array(
            'pagination'=>false
        ));

        $this->render('index', array(
            'model'=>$model,
        ));
    }

    public function actionCreate()
    {
        $this->actionUpdate(true);
    }

    public function actionUpdate($new = false)
    {
        if ($new === true)
            $model = new StoreCategory;
        else
        {
            $model = StoreCategory::model()
                ->findByPk($_GET['id']);
        }

        if (!$model)
            throw new CHttpException(404, Yii::t('StoreModule.admin', 'Категория не найдена.'));

        $form = new STabbedForm('application.modules.store.views.admin.category.categoryForm', $model);

        if (Yii::app()->request->isPostRequest)
        {
            $model->attributes = $_POST['StoreCategory'];

            if ($model->validate())
            {
                $parent=StoreCategory::model()->findByPk($_POST['StoreCategory']['parent_id']);
                if($model->getIsNewRecord())
                    $model->appendTo($parent);
                else
                {
                    $model->saveNode();
                    // Move category if parent has changed
                    if($model->id != 1 && $model->parent->id != $model->parent_id)
                        $model->moveAsLast($parent);
                }

                $this->setFlashMessage(Yii::t('StoreModule.admin', 'Изменения успешно сохранены'));

                if (isset($_POST['REDIRECT']))
                    $this->smartRedirect($model);
                else
                    $this->redirect(array('index'));
            }
        }

        $this->render('update', array(
            'model'=>$model,
            'form'=>$form,
        ));
    }

    /**
     * Delete categories
     * @param array $id
     */
    public function actionDelete($id = array())
    {
        if (Yii::app()->request->isPostRequest)
        {
            foreach ($_REQUEST['id'] as $id)
            {
                $model = StoreCategory::model()->findByPk($id);

                if ($model && $model->id != 1)
                    $model->deleteNode();
            }

            if (!Yii::app()->request->isAjaxRequest)
                $this->redirect('index');
        }
    }

}

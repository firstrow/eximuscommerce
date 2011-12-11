<?php


class ProductsController extends SAdminController
{

    /**
     * Display list of products
     */
    public function actionIndex()
    {
        $model = new StoreProduct('search');

        if (!empty($_GET['StoreProduct']))
            $model->attributes = $_GET['StoreProduct'];

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
            $model = new StoreProduct;
        else
        {
            $model = StoreProduct::model()
                ->findByPk($_GET['id']);
        }

        if (!$model)
            throw new CHttpException(404, Yii::t('StoreModule.admin', 'Продукт не найден.'));

        $form = new STabbedForm('application.modules.store.views.admin.products.productForm', $model);

        // Set additional tabs
        $form->additionalTabs = array(
            Yii::t('StoreModule.admin','Сопутствующие продукты')=>$this->renderPartial('_relatedProducts',array(
                'exclude'=>$model->id,
            ),true),
        );

        if (Yii::app()->request->isPostRequest)
        {
            $model->attributes = $_POST['StoreProduct'];

            if ($model->isNewRecord)
                $model->created = date('Y-m-d H:i:s');
            $model->updated = date('Y-m-d H:i:s');

            if ($model->validate())
            {
                $model->save();

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
     * Create gridview for "Related Products" tab
     */
    public function actionApplyProductsFilter($exclude = 0)
    {
        $model = new StoreProduct('search');
        $model->exclude = $exclude;

        if (!empty($_GET['RelatedProducts']))
            $model->attributes = $_GET['RelatedProducts'];

        $this->renderPartial('_relatedProducts', array(
            'model'=>$model,
            'exclude'=>$exclude,
        ));
    }

    public function actionDelete()
    {
        if (Yii::app()->request->isPostRequest)
        {
            $model = StoreProduct::model()->findAllByPk($_REQUEST['id']);

            if (!empty($model))
            {
                foreach($model as $page)
                    $page->delete();
            }

            if (!Yii::app()->request->isAjaxRequest)
                $this->redirect('index');
        }
    }

}

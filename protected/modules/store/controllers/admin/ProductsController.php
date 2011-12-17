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
                'product'=>$model,
            ),true),
            Yii::t('StoreModule.admin','Изображения')=>$this->renderPartial('_images', array(
                'model'=>$model,
            ), true),
            Yii::t('StoreModule.admin','Характеристики')=>'',
            Yii::t('StoreModule.admin','Свойства')=>'',
            Yii::t('StoreModule.admin','Отзывы')=>'',
        );

        if (Yii::app()->request->isPostRequest)
        {
            $model->attributes = $_POST['StoreProduct'];

            if ($model->isNewRecord)
                $model->created = date('Y-m-d H:i:s');
            $model->updated = date('Y-m-d H:i:s');

            // Handle related products
            $model->setRelatedProducts(Yii::app()->getRequest()->getPost('RelatedProductId', array()));

            if ($model->validate())
            {
                $model->save();

                // Handle images
                // TODO: Display upload errors
                $images = CUploadedFile::getInstancesByName('StoreProductImages');
                if ($images && sizeof($images) > 0)
                {
                    foreach ($images as $image)
                    {
                        if (!StoreUploadedImage::hasErrors($image))
                        {
                            $name = StoreUploadedImage::createName($model, $image);
                            $image->saveAs(StoreUploadedImage::getSavePath().'/'.$name);

                            // Check if product has main image
                            $is_main = (int) StoreProductImage::model()
                                ->countByAttributes(array(
                                    'product_id'=>$model->id,
                                    'is_main'=>1
                                ));

                            $imageModel = new StoreProductImage;
                            $imageModel->product_id = $model->id;
                            $imageModel->name = $name;
                            $imageModel->is_main = ($is_main == 0) ? true : false;
                            $imageModel->uploaded_by = Yii::app()->user->getId();
                            $imageModel->date_uploaded = date('Y-m-d H:i:s');
                            $imageModel->save();
                        }
                    }
                }

                // Set main image
                if (Yii::app()->request->getPost('mainImageId'))
                {
                    // Ensure we have no main images
                    StoreProductImage::model()->updateAll(array('is_main'=>0));
                    // Set new main image
                    StoreProductImage::model()->updateByPk(Yii::app()->request->getPost('mainImageId'),array('is_main'=>1));
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
     * Create gridview for "Related Products" tab
     * @param int $exclude Product id to exclude from list
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

    public function actionDeleteImage($id)
    {
        if (Yii::app()->request->getIsPostRequest())
        {
            $model = StoreProductImage::model()->findByPk($id);
            if ($model)
                $model->delete();
        }
    }

    /**
     * Delete products
     */
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

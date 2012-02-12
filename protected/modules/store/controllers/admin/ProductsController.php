<?php

/**
 * Manage products
 */
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

		// Pass additional params to search method.
		$params = array(
			'category'=>Yii::app()->request->getParam('category', null)
		);

		$dataProvider = $model->search($params);
		$dataProvider->pagination->pageSize = Yii::app()->params['adminPageSize'];

		$this->render('index', array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Create product
	 */
	public function actionCreate()
	{
		$this->actionUpdate(true);
	}

	/**
	 * Create/update product
	 * @param bool $new
	 * @throws CHttpException
	 */
	public function actionUpdate($new = false)
	{
		if ($new === true)
			$model = new StoreProduct;
		else
			$model = StoreProduct::model()->findByPk($_GET['id']);

		if (!$model)
			throw new CHttpException(404, Yii::t('StoreModule.admin', 'Продукт не найден.'));

		$form = new STabbedForm('application.modules.store.views.admin.products.productForm', $model);

		// On create new product first display "Choose type" form.
		if($model->isNewRecord && isset($_GET['type_id']))
		{
			$model->type_id = $_GET['type_id'];
			if(StoreProductType::model()->countByAttributes(array('id'=>$model->type_id)) === '0')
			{
				throw new CHttpException(404, Yii::t('StoreModule.admin', 'Ошибка. Тип продука указан неправильно'));
			}
		}

		// Set additional tabs
		$form->additionalTabs = array(
			Yii::t('StoreModule.admin','Категории')=>$this->renderPartial('_tree', array('model'=>$model), true),
			Yii::t('StoreModule.admin','Сопутствующие продукты')=>$this->renderPartial('_relatedProducts',array(
				'exclude'=>$model->id,
				'product'=>$model,
			),true),
			Yii::t('StoreModule.admin','Изображения')=>$this->renderPartial('_images', array('model'=>$model), true),
			Yii::t('StoreModule.admin','Характеристики')=>$this->renderPartial('_attributes', array('model'=>$model), true),
			Yii::t('StoreModule.admin','Варианты')=>$this->renderPartial('_variations', array('model'=>$model), true),
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

				// Process categories
				$model->setCategories(Yii::app()->request->getPost('categories', array()), Yii::app()->request->getPost('main_category', 1));

				// Process attributes
				$this->processAttributes($model);

                // Process variants
                $this->processVariants($model);

				// Handle images
				$images = CUploadedFile::getInstancesByName('StoreProductImages');
				if($images && sizeof($images) > 0)
				{
					foreach($images as $image)
					{
						if(!StoreUploadedImage::hasErrors($image))
						{
							$name = StoreUploadedImage::createName($model, $image);
							$fullPath = StoreUploadedImage::getSavePath().'/'.$name;
							$image->saveAs($fullPath);

							// Check if product has main image
							$is_main = (int) StoreProductImage::model()->countByAttributes(array(
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

							// Resize if needed
							Yii::import('ext.phpthumb.PhpThumbFactory');
							$thumb = PhpThumbFactory::create($fullPath);
							$sizes = Yii::app()->params['storeImages']['sizes'];
							$method = $sizes['resizeMethod'];
							$thumb->$method($sizes['maximum'][0],$sizes['maximum'][1])->save($fullPath);
						}
						else
							$this->setFlashMessage(Yii::t('StoreModule.admin', 'Ошибка загрузки изображения'));
					}
				}

				// Set main image
				if (Yii::app()->request->getPost('mainImageId'))
				{
					// Ensure we have no main images
					StoreProductImage::model()->updateAll(array('is_main'=>0), 'product_id=:pid', array(':pid'=>$model->id));
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
	 * Save custom model attributes
	 * @param StoreProduct $model
	 * @return boolean
	 */
	protected function processAttributes(StoreProduct $model)
	{
		$attributes = new CMap(Yii::app()->request->getPost('StoreAttribute', array()));
		if(empty($attributes))
			return false;

		$deleteModel = StoreProduct::model()->findByPk($model->id);
		$deleteModel->deleteEavAttributes(array(), true);

		// Delete empty values
		foreach($attributes as $key=>$val)
		{
			if(is_string($val) && $val === '')
				$attributes->remove($key);
		}

		return $model->setEavAttributes($attributes->toArray(), true);
	}

    protected function processVariants(StoreProduct $model)
    {
        $dontDelete = array();

        if(!empty($_POST['variants']))
        {
            foreach($_POST['variants'] as $attribute_id=>$values)
            {
                $i=0;
                foreach($values['option_id'] as $option_id)
                {
                    // Try to load variant from DB
                    $variant = StoreProductVariant::model()->findByAttributes(array(
                        'product_id'   => $model->id,
                        'attribute_id' => $attribute_id,
                        'option_id'    => $option_id
                    ));
                    // If not - create new.
                    if(!$variant)
                        $variant = new StoreProductVariant;

                    $variant->setAttributes(array(
                        'attribute_id' => $attribute_id,
                        'option_id'    => $option_id,
                        'product_id'   => $model->id,
                        'price'        => $values['price'][$i],
                        'price_type'   => $values['price_type'][$i],
                        'sku'          => $values['sku'][$i],
                    ), false);

                    $variant->save(false);
                    array_push($dontDelete, $variant->id);
                    $i++;
                }
            }
        }

        if(!empty($dontDelete))
        {
            $cr = new CDbCriteria;
            $cr->addNotInCondition('id', $dontDelete);
            StoreProductVariant::model()->deleteAll($cr);
        }else
            StoreProductVariant::model()->deleteAllByAttributes(array('product_id'=>$model->id));
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

    public function actionRenderVariantTable()
    {
        $attribute = StoreAttribute::model()
            ->with('options')
            ->findByPk($_GET['attr_id']);

        if(!$attribute)
            throw new CHttpException(404, Yii::t('StoreModule.admin', 'Ошибка загрузки атрибута'));

        $this->renderPartial('variants/_table', array(
            'attribute'=>$attribute
        ));
    }

	/**
	 * @param $id StoreProductImage id
	 */
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
	public function actionDelete($id = array())
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

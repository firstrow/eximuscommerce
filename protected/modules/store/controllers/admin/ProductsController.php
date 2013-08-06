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
		$dataProvider->pagination->pageSize = Yii::app()->settings->get('core', 'productsPerPageAdmin');

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
			$model = StoreProduct::model()->language($_GET)->findByPk($_GET['id']);

		if (!$model)
			throw new CHttpException(404, Yii::t('StoreModule.admin', 'Продукт не найден.'));

		// Apply use_configurations, configurable_attributes, type_id
		if(isset($_GET['StoreProduct']))
			$model->attributes = $_GET['StoreProduct'];

		// On create new product first display "Choose type" form first.
		if($model->isNewRecord && isset($_GET['StoreProduct']['type_id']))
		{
			if(StoreProductType::model()->countByAttributes(array('id'=>$model->type_id)) === '0')
				throw new CHttpException(404, Yii::t('StoreModule.admin', 'Ошибка. Тип продукта указан неправильно.'));
		}

		// Set configurable attributes on new record
		if($model->isNewRecord)
		{
			if($model->use_configurations && isset($_GET['StoreProduct']['configurable_attributes']))
				$model->configurable_attributes = $_GET['StoreProduct']['configurable_attributes'];
		}

		$form = new STabbedForm('application.modules.store.views.admin.products.productForm', $model);

		// Set additional tabs
		$form->additionalTabs = array(
			Yii::t('StoreModule.admin','Категории') => $this->renderPartial('_tree', array('model'=>$model), true),
			Yii::t('StoreModule.admin','Сопутствующие продукты') => $this->renderPartial('_relatedProducts',array(
				'exclude'=>$model->id,
				'product'=>$model,
			),true),
			Yii::t('StoreModule.admin','Изображения')    => $this->renderPartial('_images', array('model'=>$model), true),
			Yii::t('StoreModule.admin','Характеристики') => $this->renderPartial('_attributes', array('model'=>$model), true),
			Yii::t('StoreModule.admin','Варианты')       => $this->renderPartial('_variations', array('model'=>$model), true),
			Yii::t('StoreModule.admin','Отзывы')         => $this->renderPartial('_comments', array('model'=>$model), true),
		);

		if($model->use_configurations)
			$form->additionalTabs[Yii::t('StoreModule.admin','Конфигурации')] = $this->renderPartial('_configurations', array('product'=>$model), true);

		if (Yii::app()->request->isPostRequest)
		{
			$model->attributes = $_POST['StoreProduct'];

			// Handle related products
			$model->setRelatedProducts(Yii::app()->getRequest()->getPost('RelatedProductId', array()));

			if ($model->validate() && $this->validateAttributes($model))
			{
				$model->save();

				// Process categories
				$model->setCategories(Yii::app()->request->getPost('categories', array()), Yii::app()->request->getPost('main_category', 1));

				// Process attributes
				$this->processAttributes($model);

				// Process variants
				$this->processVariants($model);

				// Process configurations
				$this->processConfigurations($model);

				// Handle images
				$images = CUploadedFile::getInstancesByName('StoreProductImages');
				if($images && sizeof($images) > 0)
				{
					foreach($images as $image)
					{
						if(!StoreUploadedImage::hasErrors($image))
							$model->addImage($image);
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

				// Update image titles
				$this->updateImageTitles();

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
	 * Save model attributes
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

	/**
	 * Save product variants
	 * @param StoreProduct $model
	 */
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
			$cr->addCondition('product_id='.$model->id);
			StoreProductVariant::model()->deleteAll($cr);
		}else
			StoreProductVariant::model()->deleteAllByAttributes(array('product_id'=>$model->id));
	}

	/**
	 * Save product configurations
	 * @param StoreProduct $model
	 * @return mixed
	 */
	protected function processConfigurations(StoreProduct $model)
	{
		$productPks = Yii::app()->request->getPost('ConfigurationsProductGrid_c0', array());

		// Clear relations
		Yii::app()->db->createCommand()->delete('StoreProductConfigurations', 'product_id=:id', array(':id'=>$model->id));

		if(!sizeof($productPks))
			return;

		foreach($productPks as $pk)
		{
			Yii::app()->db->createCommand()->insert('StoreProductConfigurations', array(
				'product_id'      => $model->id,
				'configurable_id' => $pk
			));
		}
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

	/**
	 * Render configurations tab gridview.
	 */
	public function actionApplyConfigurationsFilter()
	{
		$product = StoreProduct::model()->findByPk($_GET['product_id']);

		// On create new product
		if(!$product)
		{
			$product = new StoreProduct;
			$product->configurable_attributes = $_GET['configurable_attributes'];
		}

		$this->renderPartial('_configurations', array(
			'product'=>$product,
			'clearConfigurations'=>true // Show all products
		));
	}

	/**
	 * Render comments tab
	 */
	public function actionApplyCommentsFilter()
	{
		$this->renderPartial('_comments', array(
			'model'=>StoreProduct::model()->findByPk($_GET['id'])
		));
	}

	/**
	 * @throws CHttpException
	 */
	public function actionRenderVariantTable()
	{
		$attribute = StoreAttribute::model()
			->findByPk($_GET['attr_id']);

		if(!$attribute)
			throw new CHttpException(404, Yii::t('StoreModule.admin', 'Ошибка загрузки атрибута'));

		$this->renderPartial('variants/_table', array(
			'attribute'=>$attribute
		));
	}

	/**
	 * Load attributes relative to type and available for product configurations.
	 * Used on creating new product.
	 */
	public function actionLoadConfigurableOptions()
	{
		// For configurations that  are available only dropdown and radio lists.
		$cr = new CDbCriteria;
		$cr->addInCondition('StoreAttribute.type', array(StoreAttribute::TYPE_DROPDOWN, StoreAttribute::TYPE_RADIO_LIST));
		$type = StoreProductType::model()->with(array('storeAttributes'))->findByPk($_GET['type_id'], $cr);

		$data = array();
		foreach($type->storeAttributes as $attr)
		{
			$data[] = array(
				'id'=>$attr->id,
				'title'=>$attr->title,
			);
		}

		echo json_encode($data);
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
	 * Mass product update is_active
	 */
	public function actionUpdateIsActive()
	{
		$ids       = Yii::app()->request->getPost('ids');
		$status    = (int)Yii::app()->request->getPost('status');
		$models    = StoreProduct::model()->findAllByPk($ids);
		foreach($models as $product)
		{
			if(in_array($status, array(0,1)))
			{
				$product->is_active=$status;
				$product->save();
			}
		}
		echo Yii::t('StoreModule.admin', 'Изменения успешно сохранены.');
	}

	/**
	 * Delete products
	 * @param array $id
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

	/**
	 * Validate required store attributes
	 * @param StoreProduct $model
	 * @return bool
	 */
	public function validateAttributes(StoreProduct $model)
	{
		$attributes = $model->type->storeAttributes;

		if(empty($attributes) || $model->use_configurations)
			return true;

		$errors = false;
		foreach($attributes as $attr)
		{
			if($attr->required && !isset($_POST['StoreAttribute'][$attr->name]))
			{
				$errors = true;
				$model->addError($attr->name, Yii::t('StoreModule.admin', 'Поле %s обязательно для заполнения', array('%s'=>$attr->title)));
			}
		}

		return !$errors;
	}

	/**
	 * Add option to store attribute
	 *
	 * @throws CHttpException
	 */
	public function actionAddOptionToAttribute()
	{
		$attribute = StoreAttribute::model()
			->findByPk($_GET['attr_id']);

		if(!$attribute)
			throw new CHttpException(404, Yii::t('StoreModule.admin', 'Ошибка загрузки атрибута'));

		$attributeOption = new StoreAttributeOption;
		$attributeOption->attribute_id = $attribute->id;
		$attributeOption->value        = $_GET['value'];
		$attributeOption->save(false);

		echo $attributeOption->id;
	}

	/**
	 * Updates image titles
	 */
	public function updateImageTitles()
	{
		if(sizeof(Yii::app()->request->getPost('image_titles', array())))
		{
			foreach(Yii::app()->request->getPost('image_titles', array()) as $id=>$title)
			{
				StoreProductImage::model()->updateByPk($id, array(
					'title'=>$title
				));
			}
		}
	}

	/**
	 * Render popup window
	 */
	public function actionRenderCategoryAssignWindow()
	{
		$this->renderPartial('category_assign_window');
	}

	/**
	 * Render popup windows
	 */
	public function actionRenderDuplicateProductsWindow()
	{
		$this->renderPartial('duplicate_products_window');
	}

	/**
	 * Duplicate products
	 */
	public function actionDuplicateProducts()
	{
		//TODO: return ids to find products
		$product_ids = Yii::app()->request->getPost('products', array());
		parse_str(Yii::app()->request->getPost('duplicate'), $duplicates);

		if(!isset($duplicates['copy']))
			$duplicates['copy']=array();

		$duplicator = new SProductsDuplicator;
		$ids = $duplicator->createCopy($product_ids, $duplicates['copy']);
		echo '/admin/store/products/?StoreProduct[id]='.implode(',', $ids);
	}

	/**
	 * Assign categories to products
	 */
	public function actionAssignCategories()
	{
		$categories = Yii::app()->request->getPost('category_ids');
		$products   = Yii::app()->request->getPost('product_ids');

		if(empty($categories) || empty($products))
			return;

		$products = StoreProduct::model()->findAllByPk($products);

		foreach ($products as $p)
			$p->setCategories($categories, Yii::app()->request->getPost('main_category'));
	}

}

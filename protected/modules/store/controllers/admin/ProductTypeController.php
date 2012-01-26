<?php

/**
 * Admin product types
 */
class ProductTypeController extends SAdminController {

	/**
	 * Display types list
	 */
	public function actionIndex()
	{
		$model = new StoreProductType('search');

		if (!empty($_GET['StoreProductType']))
			$model->attributes = $_GET['StoreProductType'];

		$this->render('index', array(
			'model'=>$model
		));
	}

	/**
	 * Create new product type
	 */
	public function actionCreate()
	{
		$this->actionUpdate(true);
	}
	/**
	 * Update product type
	 * @param bool $new
	 * @throws CHttpException
	 */
	public function actionUpdate($new = false)
	{
		if ($new === true)
			$model = new StoreProductType;
		else
		{
			$model = StoreProductType::model()
				->findByPk($_GET['id']);
		}

		if (!$model)
			throw new CHttpException(404, Yii::t('StoreModule.admin', 'Тип продукта не найден.'));

		if (Yii::app()->request->isPostRequest)
		{
			$model->attributes = $_POST['StoreProductType'];

			if ($model->validate())
			{
				$model->save();
				// Set type attributes
				$model->useAttributes(Yii::app()->request->getPost('attributes', array()));

				$this->setFlashMessage(Yii::t('StoreModule.admin', 'Изменения успешно сохранены'));

				if (isset($_POST['REDIRECT']))
					$this->smartRedirect($model);
				else
					$this->redirect('create');
			}
		}

		// Select available(not used) attributes
		$cr = new CDbCriteria;
		$cr->addNotInCondition('id', CHtml::listData($model->attributeRelation, 'attribute_id','attribute_id'));
		$allAttributes = StoreAttribute::model()->findAll($cr);

		$this->render('update', array(
			'model'=>$model,
			'attributes'=>$allAttributes,
		));
	}

	/**
	 * Delete type
	 * @param array $id
	 */
	public function actionDelete($id = array())
	{
		if (Yii::app()->request->isPostRequest)
		{
			$model = StoreProductType::model()->findAllByPk($_REQUEST['id']);

			if (!empty($model))
			{
				foreach($model as $m)
					$m->delete();
			}

			if (!Yii::app()->request->isAjaxRequest)
				$this->redirect('index');
		}
	}

}

<?php

/**
 * Admin manufacturer controller
 */
class ManufacturerController extends SAdminController {

	/**
	 * Display manufacturers list
	 */
	public function actionIndex()
	{
		$model = new StoreManufacturer('search');

		if (!empty($_GET['StoreManufacturer']))
			$model->attributes = $_GET['StoreManufacturer'];

		$dataProvider = $model->orderByName()->search();
		$dataProvider->pagination->pageSize = Yii::app()->settings->get('core', 'productsPerPageAdmin');

		$this->render('index', array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Create new manufacturer
	 */
	public function actionCreate()
	{
		$this->actionUpdate(true);
	}
	/**
	 * Update manufacturer
	 * @param bool $new
	 * @throws CHttpException
	 */
	public function actionUpdate($new = false)
	{
		if ($new === true)
			$model = new StoreManufacturer;
		else
		{
			$model = StoreManufacturer::model()
				->language($_GET)
				->findByPk($_GET['id']);
		}

		if (!$model)
			throw new CHttpException(404, Yii::t('StoreModule.admin', 'Производитель не найден.'));

		$form = new STabbedForm('application.modules.store.views.admin.manufacturer.manufacturerForm', $model);
		$form->summaryOnEachTab = true;

		if (Yii::app()->request->isPostRequest)
		{
			$model->attributes = $_POST['StoreManufacturer'];

			if ($model->validate())
			{
				$model->save();
				$this->setFlashMessage(Yii::t('StoreModule.admin', 'Изменения успешно сохранены'));

				if (isset($_POST['REDIRECT']))
					$this->smartRedirect($model);
				else
					$this->redirect('create');
			}
		}

		$this->render('update', array(
			'model'=>$model,
			'form'=>$form,
		));
	}

	/**
	 * Delete manufacturer
	 * @param array $id
	 */
	public function actionDelete($id = array())
	{
		if (Yii::app()->request->isPostRequest)
		{
			$model = StoreManufacturer::model()->findAllByPk($_REQUEST['id']);

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

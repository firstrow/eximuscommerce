<?php

/**
 * Admin attribute controller
 */
class AttributeController extends SAdminController {

	/**
	 * Display attribute list
	 */
	public function actionIndex()
	{
		$model = new StoreAttribute('search');

		if (!empty($_GET['StoreAttribute']))
			$model->attributes = $_GET['StoreAttribute'];

		$this->render('index', array(
			'model'=>$model
		));
	}

	/**
	 * Create new attribute
	 */
	public function actionCreate()
	{
		$this->actionUpdate(true);
	}
	/**
	 * Update attribute
	 * @param bool $new
	 * @throws CHttpException
	 */
	public function actionUpdate($new = false)
	{
		if ($new === true)
			$model = new StoreAttribute;
		else
		{
			$model = StoreAttribute::model()
				->findByPk($_GET['id']);
		}

		if (!$model)
			throw new CHttpException(404, Yii::t('StoreModule.admin', 'Атрибут не найден.'));

		$form = new STabbedForm('application.modules.store.views.admin.attribute.attributeForm', $model);

		if (Yii::app()->request->isPostRequest)
		{
			$model->attributes = $_POST['StoreAttribute'];

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
	 * Delete attribute
	 * @param array $id
	 */
	public function actionDelete($id = array())
	{
		if (Yii::app()->request->isPostRequest)
		{
			$model = StoreAttribute::model()->findAllByPk($_REQUEST['id']);

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

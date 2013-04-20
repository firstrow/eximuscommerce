<?php

/**
 * Discounts controller
 */
class DefaultController extends SAdminController
{

	/**
	 * Display discounts list
	 */
	public function actionIndex()
	{
		$model = new Discount('search');

		if (!empty($_GET['Discount']))
			$model->attributes = $_GET['Discount'];

		$dataProvider = $model->orderByName()->search();
		$dataProvider->pagination->pageSize = Yii::app()->settings->get('core', 'productsPerPageAdmin');

		$this->render('index', array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Create new discount
	 */
	public function actionCreate()
	{
		$this->actionUpdate(true);
	}
	/**
	 * Update discount
	 * @param bool $new
	 * @throws CHttpException
	 */
	public function actionUpdate($new = false)
	{
		if ($new === true)
			$model = new Discount;
		else
			$model = Discount::model()->findByPk($_GET['id']);

		if (!$model)
			throw new CHttpException(404, Yii::t('DiscountsModule.admin', 'Скидка не найдена.'));

		if (Yii::app()->request->isPostRequest)
		{
			if(!isset($_POST['Discount']['manufacturers']))
				$model->manufacturers = array();
			if(!isset($_POST['Discount']['categories']))
				$model->categories = array();
			if(!isset($_POST['Discount']['userRoles']))
				$model->userRoles = array();

			$model->attributes = $_POST['Discount'];
		}

		$form = new STabbedForm('discounts.views.admin.default.discountForm', $model);

		$form->additionalTabs = array(
			Yii::t('DiscountsModule.admin','Категории') => $this->renderPartial('_categories', array('model'=>$model), true),
		);

		$form->summaryOnEachTab = true;

		if (Yii::app()->request->isPostRequest)
		{
			if ($model->validate())
			{
				$model->save();
				$this->setFlashMessage(Yii::t('DiscountsModule.admin', 'Изменения успешно сохранены'));

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
	 * Delete discount
	 * @param array $id
	 */
	public function actionDelete($id = array())
	{
		if (Yii::app()->request->isPostRequest)
		{
			$model = Discount::model()->findAllByPk($_REQUEST['id']);

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
<?php

/**
 * Admin currencies
 */
class CurrencyController extends SAdminController {

	/**
	 * Display currency list
	 */
	public function actionIndex()
	{
		$model = new StoreCurrency('search');

		if (!empty($_GET['StoreCurrency']))
			$model->attributes = $_GET['StoreCurrency'];

		$dataProvider = $model->search();
		$dataProvider->pagination->pageSize = Yii::app()->settings->get('core', 'productsPerPageAdmin');

		$this->render('index', array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Create new currency
	 */
	public function actionCreate()
	{
		$this->actionUpdate(true);
	}
	/**
	 * Update currency
	 * @param bool $new
	 * @throws CHttpException
	 */
	public function actionUpdate($new = false)
	{
		if ($new === true)
		{
			$model = new StoreCurrency;
			$model->unsetAttributes();
		}
		else
		{
			$model = StoreCurrency::model()
				->findByPk($_GET['id']);
		}

		if (!$model)
			throw new CHttpException(404, Yii::t('StoreModule.admin', 'Валюта не найдена.'));

		$form = new CForm('store.views.admin.currency.currencyForm', $model);

		if (Yii::app()->request->isPostRequest)
		{
			$model->attributes = $_POST['StoreCurrency'];

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
	 * Delete currency
	 * @param array $id
	 */
	public function actionDelete($id = array())
	{
		if (Yii::app()->request->isPostRequest)
		{
			$model = StoreCurrency::model()->findAllByPk($_REQUEST['id']);

			if (!empty($model))
			{
				foreach($model as $m)
				{
					if($m->main)
						throw new CHttpException(404, Yii::t('StoreModule.admin', 'Ошибка. Удаление главной валюты запрещено.'));
					if($m->default)
						throw new CHttpException(404, Yii::t('StoreModule.admin', 'Ошибка. Удаление валюты по умолчанию запрещено.'));

					$m->delete();
				}
			}

			if (!Yii::app()->request->isAjaxRequest)
				$this->redirect('index');
		}
	}

}

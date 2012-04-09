<?php

/**
 * Admin payment methods
 */
class PaymentMethodController extends SAdminController {

	/**
	 * Display payment methods list
	 */
	public function actionIndex()
	{
		$model = new StorePaymentMethod('search');

		if (!empty($_GET['StoreDeliveryMethod']))
			$model->attributes = $_GET['StorePaymentMethod'];

		$dataProvider = $model->search();
		$dataProvider->pagination->pageSize = Yii::app()->params['adminPageSize'];

		$this->render('index', array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Create new payment methods
	 */
	public function actionCreate()
	{
		$this->actionUpdate(true);
	}
	/**
	 * Update payment method
	 * @param bool $new
	 * @throws CHttpException
	 */
	public function actionUpdate($new = false)
	{
		if ($new === true)
		{
			$model = new StorePaymentMethod;
			$model->unsetAttributes();
		}
		else
			$model = StorePaymentMethod::model()->language($_GET)->findByPk($_GET['id']);

		if (!$model)
			throw new CHttpException(404, Yii::t('StoreModule.admin', 'Способ оплаты не найден.'));

		$form = new CForm('store.views.admin.paymentMethod.paymentMethodForm', $model);

		if (Yii::app()->request->isPostRequest)
		{
			$model->attributes = $_POST['StorePaymentMethod'];

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
	 * Delete method
	 * @param array $id
	 */
	public function actionDelete($id = array())
	{
		if (Yii::app()->request->isPostRequest)
		{
			$model = StorePaymentMethod::model()->findAllByPk($_REQUEST['id']);

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

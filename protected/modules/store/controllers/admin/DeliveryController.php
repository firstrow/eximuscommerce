<?php

/**
 * Admin delivery methods
 */
class DeliveryController extends SAdminController {

	/**
	 * Display delivery methods list
	 */
	public function actionIndex()
	{
		$model = new StoreDeliveryMethod('search');
		$model->unsetAttributes();

		if (!empty($_GET['StoreDeliveryMethod']))
			$model->attributes = $_GET['StoreDeliveryMethod'];

		$dataProvider = $model->search();
		$dataProvider->pagination->pageSize = Yii::app()->settings->get('core', 'productsPerPageAdmin');

		$this->render('index', array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Create new delivery methods
	 */
	public function actionCreate()
	{
		$this->actionUpdate(true);
	}
	/**
	 * Update delivery method
	 * @param bool $new
	 * @throws CHttpException
	 */
	public function actionUpdate($new = false)
	{
		if ($new === true)
		{
			$model = new StoreDeliveryMethod;
			$model->unsetAttributes();
		}
		else
		{
			$model = StoreDeliveryMethod::model()
				->language($_GET)
				->findByPk($_GET['id']);
		}

		if (!$model)
			throw new CHttpException(404, Yii::t('StoreModule.admin', 'Способ доставки не найден.'));

		$form = new CForm('store.views.admin.delivery.deliveryForm', $model);

		if (Yii::app()->request->isPostRequest)
		{
			$model->attributes = $_POST['StoreDeliveryMethod'];

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
			$model = StoreDeliveryMethod::model()->findAllByPk($_REQUEST['id']);

			if (!empty($model))
			{
				foreach($model as $m)
				{
					if($m->countOrders() == 0)
						$m->delete();
					else
						throw new CHttpException(409, Yii::t('OrdersModule.admin','Ошибка удаления способа доставки. Он используется заказами.'));
				}
			}

			if (!Yii::app()->request->isAjaxRequest)
				$this->redirect('index');
		}
	}

}

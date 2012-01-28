<?php

class DefaultController extends SAdminController
{

	/**
	 * Display admin start page.
	 */
	public function actionIndex()
	{
		Yii::import('application.modules.store.models.*');
		$model = StoreProduct::model()->findByPk(21);
		var_dump($model->getEavAttributes(array('color')));
		$this->render('index');
	}

}

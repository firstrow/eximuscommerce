<?php

class DefaultController extends SAdminController
{

	/**
	 * Display admin start page.
	 */
	public function actionIndex()
	{
		Yii::app()->request->redirect($this->createUrl('/orders/admin/orders'));
		//$this->render('index');
	}

}

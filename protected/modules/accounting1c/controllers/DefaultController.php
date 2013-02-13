<?php

/**
 * Accepts request from 1C
 */
class DefaultController extends Controller
{

	public function actionIndex()
	{
		$request=Yii::app()->request;

		if($request->getQuery('password') != Yii::app()->settings->get('accounting1c', 'password'))
			exit('ERR_WRONG_PASS');

		if($request->userHostAddress != Yii::app()->settings->get('accounting1c', 'ip'))
			exit('ERR_WRONG_IP');

		if($request->getQuery('type') && $request->getQuery('mode'))
		{
			Yii::import('application.modules.accounting1c.components.C1ProductsImport');
			C1ProductsImport::processRequest($request->getQuery('type'), $request->getQuery('mode'));
		}
	}

}

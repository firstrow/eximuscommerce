<?php

/**
 * Accepts request from 1C
 */
class DefaultController extends Controller
{

	public function actionIndex()
	{
		Yii::import('application.modules.accounting1c.components.C1ProductsImport');

		$request=Yii::app()->request;
		if($request->getQuery('type') && $request->getQuery('mode'))
		{
			C1ProductsImport::processRequest($request->getQuery('type'), $request->getQuery('mode'));
		}
	}

}

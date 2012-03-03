<?php

class AjaxController extends Controller
{

	
	/**
	 * Set currency for user session.
	 * Used by currency selector on the.
	 */
	public function actionActivateCurrency()
	{
		Yii::app()->currency->setActive(Yii::app()->request->getParam('id'));
	}

}
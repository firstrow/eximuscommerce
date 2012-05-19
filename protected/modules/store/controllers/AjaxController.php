<?php

/**
 * Handle ajax requests
 */
class AjaxController extends Controller
{

	
	/**
	 * Set currency for user session.
	 */
	public function actionActivateCurrency()
	{
		Yii::app()->currency->setActive(Yii::app()->request->getParam('id'));
	}

}
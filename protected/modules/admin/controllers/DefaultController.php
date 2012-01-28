<?php

class DefaultController extends SAdminController
{

	/**
	 * Display admin start page.
	 */
	public function actionIndex()
	{
		$this->render('index');
	}

}

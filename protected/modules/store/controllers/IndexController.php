<?php

/**
 * Store start page controller
 */
class IndexController extends Controller
{

	public function actionIndex()
	{
		$this->render('index', array());
	}

}

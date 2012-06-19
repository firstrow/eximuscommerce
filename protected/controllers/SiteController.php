<?php
class SiteController extends Controller {


	public function allowedActions()
	{
		return 'login, index, error, contact';
	}

	public function actionIndex()
	{

	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		$error=Yii::app()->errorHandler->error;
		if($error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				var_dump($error);
		}else{
			echo 'Error.';
		}
	}
}

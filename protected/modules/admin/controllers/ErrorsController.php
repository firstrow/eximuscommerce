<?php

class ErrorsController extends Controller
{
	public function actionError()
	{
		$this->layout = 'application.modules.admin.views.layouts.main';
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', array('error'=>$error));
		}
	}

}

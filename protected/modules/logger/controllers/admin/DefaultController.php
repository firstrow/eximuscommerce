<?php

Yii::import('application.modules.logger.models.ActionLog');

/**
 * Logger controller
 */
class DefaultController extends SAdminController
{

	public function actionIndex()
	{
		$model = new ActionLog('search');

		if (!empty($_GET['ActionLog']))
			$model->attributes = $_GET['ActionLog'];

		$dataProvider = $model->search();
		$dataProvider->pagination->pageSize = Yii::app()->params['adminPageSize'];

		$this->render('index', array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));
	}

}

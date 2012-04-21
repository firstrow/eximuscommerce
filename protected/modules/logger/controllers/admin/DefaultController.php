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

	/**
	 * Delete products
	 */
	public function actionDelete($id = array())
	{
		if (Yii::app()->request->isPostRequest)
		{
			$model = ActionLog::model()->findAllByPk($_REQUEST['id']);

			if (!empty($model))
			{
				foreach($model as $page)
					$page->delete();
			}

			if (!Yii::app()->request->isAjaxRequest)
				$this->redirect('index');
		}
	}

}

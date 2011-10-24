<?php

class DefaultController extends SAdminController {
	
	public function actionIndex()
	{
		$model = new Page('search');

		$this->render('index', array(
			'model'=>$model
		));
	}

	public function actionCreate()
	{
		$this->actionUpdate(true);
	}

	public function actionUpdate($new = false)
	{
		if ($new === true)
			$model = new Page;
		else
			$model = Page::model()->findByPk($_GET['id']);

		if (!$model)
            throw new CHttpException(400, 'Bad request.');  

		$form = new STabbedForm('application.modules.pages.views.admin.default.pageForm', $model);

		if (Yii::app()->request->isPostRequest)
		{
			$model->attributes = $_POST['Page'];

			if ($model->validate())
			{
				$model->save();
			}
		}

		$this->render('update', array(
			'form'=>$form,
			'model'=>$model,
		));
	}
}
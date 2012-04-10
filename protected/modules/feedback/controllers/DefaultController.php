<?php

class DefaultController extends Controller
{

	/**
	 * Display feedback form
	 */
	public function actionIndex()
	{
		Yii::import('feedback.models.FeedbackForm');
		$model = new FeedbackForm;

		if(isset($_POST['FeedbackForm']))
			$model->attributes = $_POST['FeedbackForm'];

		if(Yii::app()->request->isPostRequest && $model->validate())
		{
			$model->sendMessage();
			Yii::app()->request->redirect($this->createUrl('index'));
		}

		$this->render('index', array(
			'model'=>$model
		));
	}

}

<?php

/**
 * Feedback module admin
 */
class DefaultController extends SAdminController
{

	/**
	 * Update module settings
	 */
	public function actionIndex()
	{
		Yii::import('feedback.models.FeedbackAdminForm');
		$model = new FeedbackAdminForm;

		if(isset($_POST['FeedbackAdminForm']))
		{
			$model->attributes = $_POST['FeedbackAdminForm'];
			if($model->validate())
			{
				$model->save();
				$this->setFlashMessage(Yii::t('FeedbackModule.admin', 'Изменения успешно сохранены'));
				Yii::app()->request->redirect(Yii::app()->createUrl('/core/admin/systemModules'));
			}
		}

		$this->render('index', array(
			'model'=>$model,
		));
	}

}

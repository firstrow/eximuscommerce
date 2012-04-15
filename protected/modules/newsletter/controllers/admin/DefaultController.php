<?php

/**
 * Default controller
 */
class DefaultController extends SAdminController
{

	/**
	 * Display sending form
	 */
	public function actionIndex()
	{
		Yii::import('application.modules.newsletter.models.NewsletterAdminForm');

		$model = new NewsletterAdminForm;

		if(isset($_POST['NewsletterAdminForm']))
			$model->attributes = $_POST['NewsletterAdminForm'];

		if(Yii::app()->request->isPostRequest && $model->validate())
		{
			$model->send();
			$this->setFlashMessage(Yii::t('NewsletterModule.admin', 'Сообщение успешно отправлено.'));
			if(!$model->test)
				Yii::app()->request->redirect($this->createUrl('index'));
		}

		$this->render('index', array(
			'model'=>$model,
		));
	}

}

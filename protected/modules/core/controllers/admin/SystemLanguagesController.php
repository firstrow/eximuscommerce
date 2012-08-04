<?php

/**
 * Manage system languages
 * @package core.systemLanguages
 */
class SystemLanguagesController extends SAdminController
{

	public function actionIndex()
	{
		$model = new SSystemLanguage('search');

		if (!empty($_GET['SSystemLanguage']))
			$model->attributes = $_GET['SSystemLanguage'];

		$this->render('index', array(
			'model'=>$model,
		));
	}

	public function actionCreate()
	{
		$this->actionUpdate(true);
	}

	public function actionUpdate($new = false)
	{
		if ($new === true)
			$model = new SSystemLanguage;
		else
			$model = SSystemLanguage::model()->findByPk($_GET['id']);

		if (!$model)
			throw new CHttpException(404, Yii::t('CoreModule.core', 'Язик не найден.'));

		$form = new SAdminForm('application.modules.core.views.admin.systemLanguages.languageForm', $model);

		if (Yii::app()->request->isPostRequest)
		{
			$model->attributes = $_POST['SSystemLanguage'];

			if ($model->validate())
			{
				$model->save();

				$this->setFlashMessage(Yii::t('CoreModule.core', 'Изменения успешно сохранены'));

				if (isset($_POST['REDIRECT']))
					$this->smartRedirect($model);
				else
					$this->redirect(array('index'));
			}
		}

		$this->render('update', array(
			'model'=>$model,
			'form'=>$form,
		));
	}

	/**
	 * Delete language
	 */
	public function actionDelete()
	{
		if (Yii::app()->request->isPostRequest)
		{
			$model = SSystemLanguage::model()->findAllByPk($_REQUEST['id']);

			if(!empty($model))
			{
				foreach($model as $page)
					$page->delete();
			}

			if (!Yii::app()->request->isAjaxRequest)
				$this->redirect('index');
		}
	}

}
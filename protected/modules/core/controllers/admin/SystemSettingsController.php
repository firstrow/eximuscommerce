<?php

class SystemSettingsController extends SAdminController
{
	public function actionIndex()
	{
		$model = new SystemSettingsForm;

		if(isset($_POST['SystemSettingsForm']))
		{
			$model->attributes=$_POST['SystemSettingsForm'];

			if($model->validate())
			{
				$model->save();
				$this->setFlashMessage(Yii::t('CoreModule.admin', 'Изменения успешно сохранены'));
				$this->refresh();
			}
		}

		$form = new STabbedForm('application.modules.core.views.admin.systemSettings.settingsForm', $model);
		$this->render('index', array(
			'form'=>$form
		));
	}
}

<?php

/**
 * Configure admin panel
 */
class DefaultController extends SAdminController
{
	/**
	 * Update module settings
	 */
	public function actionIndex()
	{
		Yii::import('application.modules.accounting1c.models.AccountingConfigForm');
		$model = new AccountingConfigForm;

		if(isset($_POST['AccountingConfigForm']))
		{
			$model->attributes = $_POST['AccountingConfigForm'];
			if($model->validate())
			{
				$model->save();
				$this->setFlashMessage(Yii::t('Accounting1cModule.admin', 'Изменения успешно сохранены'));
				Yii::app()->request->redirect(Yii::app()->createUrl('/core/admin/systemModules'));
			}
		}

		$this->render('index', array(
			'model'=>$model,
		));
	}
}

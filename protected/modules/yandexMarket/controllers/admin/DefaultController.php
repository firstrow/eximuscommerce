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
		Yii::import('application.modules.yandexMarket.models.YandexMarketConfigForm');
		$model = new YandexMarketConfigForm;

		if(isset($_POST['YandexMarketConfigForm']))
		{
			$model->attributes = $_POST['YandexMarketConfigForm'];
			if($model->validate())
			{
				$model->save();
				$this->setFlashMessage(Yii::t('YandexMarketModule.admin', 'Изменения успешно сохранены'));
				Yii::app()->request->redirect(Yii::app()->createUrl('/core/admin/systemModules'));
			}
		}

		$this->render('index', array(
			'model'=>$model,
		));
	}
}

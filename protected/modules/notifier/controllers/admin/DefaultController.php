<?php

class DefaultController extends SAdminController
{

	/**
	 * Display list of requests
	 */
	public function actionIndex()
	{
		$this->render('index', array(
			'dataProvider' => ProductNotifications::model()->search()
		));
	}

	/**
	 * Send emails
	 */
	public function actionSend()
	{
		$lang     = Yii::app()->language;
		$record   = ProductNotifications::model()->findAllByAttributes(array('product_id'=>$_GET['product_id']));
		$siteName = Yii::app()->settings->get('core', 'siteName');
		$host     = $_SERVER['HTTP_HOST'];

		foreach ($record as $row)
		{
			if(!$row->product)
				continue;

			$theme = Yii::t('NotifierModule.admin', '{site_name} уведомляет о наличии интересующего Вас продукта',array(
				'{site_name}' => $siteName
			));

			$mailer           = Yii::app()->mail;
			$mailer->From     = 'robot@'.$host;
			$mailer->FromName = Yii::app()->settings->get('core', 'siteName');
			$mailer->Subject  = $theme;
			$mailer->Body     = $this->renderFile(
				Yii::getPathOfAlias("application.emails.$lang").'/product_notification.php',
				array(
					'product'  => $row->product,
					'sitename' => $siteName
				),
				true
			);
			$mailer->AddAddress($row->email);
			$mailer->AddReplyTo('robot@'.Yii::app()->params['adminEmail']);
			$mailer->isHtml(true);
			$mailer->Send();
			$mailer->ClearAddresses();

			$row->delete();
		}

		$this->setFlashMessage(Yii::t('NotifierModule.admin', 'Сообщения успешно отправлены.'));
		$this->redirect('index');
	}

	/**
	 * Delete requests
	 */
	public function actionDelete()
	{
		$model = ProductNotifications::model()->findByPk(Yii::app()->request->getParam('id'));

		if($model)
		{
			ProductNotifications::model()->deleteAllByAttributes(array(
				'product_id' => $model->product_id
			));
		}
	}
}
<?php

class DefaultController extends SAdminController
{

	public function actionIndex()
	{
		$this->render('index', array(
			'dataProvider' => ProductNotifications::model()->search()
		));
	}

	public function actionSend()
	{
		$record = ProductNotifications::model()->findAllByAttributes(array('product_id'=>$_GET['product_id']));

		foreach ($record as $row)
		{
			if(!$row->product)
				continue;

			$theme='Yumilife.ru уведомляет о наличии интересующего Вас продукта';

			$mailer           = Yii::app()->mail;
			$mailer->From     = 'sales@yumilife.ru';
			$mailer->FromName = 'Магазин YUMILIFE.RU';
			$mailer->Subject  = $theme;
			$mailer->Body     = $this->renderFile(
				Yii::getPathOfAlias('application.emails').'/product_notification.php',
				array('product'=>$row->product),
				true
			);
			$mailer->AddAddress($row->email);
			$mailer->AddReplyTo('sales@yumilife.ru');
			$mailer->isHtml(true);
			$mailer->Send();
			$mailer->ClearAddresses();
			
			$row->delete();
		}

		$this->setFlashMessage('Сообщения успешно отправлены.');
		$this->redirect('index');
	}

}
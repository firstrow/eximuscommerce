<?php

/**
 * Allow user to receive email when product appears at the store.
 */
class NotifierModule extends BaseModule
{

	public $moduleName = 'notifier';

	public function init()
	{
		$this->setImport(array(
			'notifier.models.ProductNotifications',
		));
	}

	public function afterInstall()
	{
		$db=Yii::app()->db;
		$db->createCommand()->createTable('notifications', array(
			'id'          => 'INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT',
			'product_id'  => 'integer',
			'email'       => 'string',
		));
		$db->createCommand()->createIndex('product_id', 'notifications','product_id');
	}

	public function afterRemove()
	{
		Yii::app()->db->createCommand()->dropTable('notifications');
		Yii::app()->settings->clear('notifier');
	}

	public static function renderDialog()
	{
		Yii::app()->controller->renderFile(Yii::getPathOfAlias('application.modules.notifier.views.shared').'/_notifier.php');
	}

}
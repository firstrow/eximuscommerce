<?php

/**
 * 1C support module
 */
class Accounting1cModule extends BaseModule
{
	public $moduleName='accounting1c';

	public function afterInstall()
	{
		Yii::app()->settings->set('accounting1c', array(
			'ip'       => '127.0.0.1',
			'password' => sha1(microtime()),
			'tempdir'  => 'application.runtime',
		));

		$db=Yii::app()->db;
		$db->createCommand()->createTable('accounting1c', array(
			'id'         =>'INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT',
			'object_id'  =>'integer',
			'object_type'=>'integer',
			'external_id'=>'string',
		));
		$db->createCommand()->createIndex('object_type', 'accounting1c','object_type');
		$db->createCommand()->createIndex('external_id', 'accounting1c','external_id');
	}

	public function afterRemove()
	{
		$db=Yii::app()->db;
		$db->createCommand()->dropTable('accounting1c');
		Yii::app()->settings->clear('accounting1c');
	}

}

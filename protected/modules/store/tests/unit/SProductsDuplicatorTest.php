<?php

Yii::import('application.modules.store.components.*');

class SProductsDuplicatorTest extends  CTestCase
{
	public function testProductDuplicate()
	{
		$model      = StoreProduct::model()->find();
		$duplicator = new SProductsDuplicator();

		$clone = $duplicator->duplicateProduct($model);
		$this->assertEquals($clone->name, $model->name.$duplicator->getSuffix());
	}
}
<?php

class StoreImagesConfigTest extends CTestCase
{
	public function testSettings()
	{
		Yii::import('application.modules.store.components.StoreImagesConfig');

		$this->assertEquals(StoreImagesConfig::get('path'), 'webroot.uploads.product');

		// Test loading from db
		$r1=rand(800,2000);
		$r2=rand(800,2000);

		Yii::app()->settings->set(StoreImagesConfig::$settings_key, array(
			'maximum_image_size'=>$r1.'x'.$r2
		));

		StoreImagesConfig::initialize();

		$this->assertEquals(StoreImagesConfig::get('maximum_image_size'), array($r1, $r2));
	}
}
<?php

/**
 * Test for SSystemSettings
 */
class SSystemSettingsTest extends CTestCase
{
	public function testSetAndGet()
	{
		$val=microtime(true);
		Yii::app()->settings->set('settings_test', array(
			'key'=>$val,
		));

		$this->assertTrue(is_array(Yii::app()->settings->get('settings_test')));
		$this->assertTrue(Yii::app()->settings->get('settings_test','key')===$val);

		Yii::app()->settings->clear('settings_test');
		$this->assertTrue(Yii::app()->settings->get('settings_test','key')===null);
	}

}

<?php

Yii::import('application.components.payment.*');

/**
 * Test for SPaymentSystemManager
 */
class SPaymentSystemManagerTest extends CTestCase
{

	public function testGetSystems()
	{
		$manager=new SPaymentSystemManager();
		$systems = $manager->getSystems();
		$this->assertTrue(is_array($systems));
		$this->assertArrayHasKey('webmoney', $systems);
		$this->assertTrue($systems['webmoney'] instanceof SimpleXMLElement);
	}

	public function testGetSystemInfo()
	{
		$manager=new SPaymentSystemManager();
		$info=$manager->getSystemInfo('webmoney');
		$this->assertTrue($info instanceof SimpleXMLElement);
	}

	public function testGetSystemClass()
	{
		$manager=new SPaymentSystemManager();
		$class=$manager->getSystemClass('webmoney');
		$this->assertTrue($class instanceof BasePaymentSystem);
	}

}

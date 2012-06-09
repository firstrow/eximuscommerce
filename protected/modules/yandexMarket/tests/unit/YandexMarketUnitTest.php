<?php

class YandexMarketUnitTest extends CTestCase
{
	public function testCreateXmlFile()
	{
		$_SERVER['SERVER_NAME']='cms';
		Yii::import('application.modules.yandexMarket.components.YandexMarketXML');
		$yml=new YandexMarketXML();
		$yml->cacheFileName='test.yml';
		$yml->createXmlFile();
		$this->assertTrue(file_exists($yml->getXmlFileFullPath()));
		unlink($yml->getXmlFileFullPath());
	}
}

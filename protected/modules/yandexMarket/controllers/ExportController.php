<?php

Yii::import('application.modules.yandexMarket.components.YandexMarketXML');

class ExportController extends Controller
{
	public function actionIndex()
	{
		$xml=new YandexMarketXML;
		$xml->processRequest();
	}
}

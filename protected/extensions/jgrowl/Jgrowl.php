<?php

class Jgrowl extends CComponent
{
	public static function register()
	{
		$assetsUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('ext.jgrowl.assets'),
			false,
			-1,
			YII_DEBUG
		);

		$cs = Yii::app()->clientScript;
		$cs->registerCssFile($assetsUrl.'/jquery.jgrowl.css');
		$cs->registerScriptFile($assetsUrl.'/jquery.jgrowl.js');
	}
}

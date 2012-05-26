<?php

/**
 * Draw tinymce editor
 */
class STinyMceArea extends CInputWidget
{

	static $initialized=false;

	public function init()
	{
		if(self::$initialized===false)
		{
			self::$initialized=true;
			$assetsUrl = Yii::app()->getAssetManager()->publish(
				Yii::getPathOfAlias('ext.tinymce.assets'),
				true,
				-1,
				YII_DEBUG
			);

			$cs=Yii::app()->clientScript;
			$cs->registerScriptFile($assetsUrl.'/tiny_mce/jquery.tinymce.js');
			$cs->registerScript(__CLASS__, 'var tinyMceUrl="'.$assetsUrl.'/tiny_mce/tiny_mce.js'.'";', CClientScript::POS_HEAD);
			$cs->registerScriptFile($assetsUrl.'/functions.js');
		}
	}

	public function run()
	{
		list($name, $id) = $this->resolveNameID();

		if($this->hasModel())
			echo CHtml::activeTextArea($this->model, $this->attribute, $this->htmlOptions);
		else
			echo CHtml::textArea($name, $this->value, $this->htmlOptions);
		echo '<p class="hint"><a onclick="return setupTinyMce(\'#'.$id.'\', this);">WYSIWYG</a></p>';
	}
}

<?php

class SElrteArea extends CInputWidget
{
	static $initialized=false;

	/**
	 * Initialize component
	 */
	public function init()
	{
		if(self::$initialized===false)
		{
			self::$initialized=true;
			$assetsUrl = Yii::app()->getAssetManager()->publish(
				Yii::getPathOfAlias('ext.elrte.lib'),
				false,
				-1,
				YII_DEBUG
			);

			$cs=Yii::app()->clientScript;
			
			// Elrte
			$cs->registerCssFile($assetsUrl.'/elrte/css/elrte.min.css');
			$cs->registerScriptFile($assetsUrl.'/elrte/js/elrte.min.js');
			$cs->registerScriptFile($assetsUrl.'/elrte/js/i18n/elrte.ru.js');
			// Elfinder
			$cs->registerCssFile($assetsUrl.'/elfinder/css/elfinder.min.css');
			$cs->registerCssFile($assetsUrl.'/elfinder/css/theme.css');
			$cs->registerScriptFile($assetsUrl.'/elfinder/js/elfinder.min.js');
			$cs->registerScriptFile($assetsUrl.'/elfinder/js/i18n/elfinder.ru.js');

			$cs->registerScriptFile($assetsUrl.'/helper.js');
		}
	
		parent::init();
	}

	public function run()
	{
		$theme = Yii::app()->settings->get('core', 'editorTheme');
		if(!$theme)
			$theme = 'compant';
		$height = Yii::app()->settings->get('core', 'editorHeight');
		if($height < 50)
			$height = 150;

		list($name, $id) = $this->resolveNameID();

		if($this->hasModel())
			echo CHtml::activeTextArea($this->model, $this->attribute, $this->htmlOptions);
		else
			echo CHtml::textArea($name, $this->value, $this->htmlOptions);
		
		if(Yii::app()->settings->get('core', 'editorAutoload'))
			Yii::app()->clientScript->registerScript(__CLASS__.$id,'setupElrteEditor(\''.$id.'\', this, \''.$theme.'\', \''.$height.'\');', CClientScript::POS_READY);
		else
			echo '<div class="hint"><a onclick="return setupElrteEditor(\''.$id.'\', this, \''.$theme.'\', \''.$height.'\');">WYSIWYG</a></div>';
	}

}

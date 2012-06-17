<?php

Yii::import('web.widgets.CWidget');

/**
 * Display vertical tabs in sidebar
 * @package ext.sidebartabs
 */
class SAdminSidebarTabs extends CWidget {

	public $tabs=array();

	public function run()
	{
		$sidebarContent = '';

		$n=0;
		echo CHtml::openTag('div', array('class'=>'SidebarTabsContent'));
		foreach ($this->tabs as $title => $content)
		{
			echo CHtml::openTag('div', array(
				'id'=>'tab_'.$n,
				'class'=>'tab',
			));
			echo $content;
			echo CHtml::closeTag('div');

			$sidebarContent .= '<li><a href="#" onClick="SidebarShowTab(\'tab_'.$n.'\', this); return false;">'.$title.'</a></li>';
			$n++;
		}
		echo CHtml::closeTag('div');

		$this->registerScripts();
		$this->getOwner()->sidebarContent = '<ul class="SidebarTabsControl">'.$sidebarContent.'</ul>';
	}

	public function registerScripts()
	{
		$assetsUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('ext.sidebartabs.assets'),
			false,
			-1,
			YII_DEBUG
		);

		$cs = Yii::app()->clientScript;
		$cs->registerScriptFile($assetsUrl.'/sidebartabs.scripts.js');
		$cs->registerCssFile($assetsUrl.'/sidebartabs.css');
	}

}
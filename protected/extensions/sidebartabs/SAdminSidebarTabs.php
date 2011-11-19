<?php

Yii::import('web.widgets.CWidget');

/**
 * Display tabs in sidebar
 * @package ext.sidebartabs
 */
class SAdminSidebarTabs extends CWidget {
	
	public $tabs=array();

	public function run()
	{
		$this->getOwner()->sidebarContent = '<h3>&nbsp;</h3>';
		$this->registerScripts();

		$n=0;
		echo '<div class="tabs_content">';
		foreach ($this->tabs as $title => $content) 
		{
			echo '<div class="tab" id="tab_'.sha1($title.$n).'">';
			echo $content;
			echo '</div>';

			$this->getOwner()->sidebarContent.='<a href="#" onClick="showTab(\'tab_'.sha1($title.$n).'\'); return false;">'.$title.'</a><br/>';
			$n++;
		}
		echo '</div>';
	}

	public function registerScripts()
	{
		Yii::app()->clientScript->registerScript("dddddd",'
			$(document).ready(function() {
				$(".tabs_content .tab").hide(); //Hide all content
				$(".tabs_content .tab:first").show(); //Show first tab content
			});
		');

		Yii::app()->clientScript->registerScript("dfdf",'
			function showTab(id, el)
			{
				$(".tabs_content .tab").hide();
				$("#"+id).show();
			}
		',CClientScript::POS_HEAD);
	}

}
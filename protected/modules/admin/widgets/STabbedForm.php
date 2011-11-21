<?php
/**
 * Render form using jquery tabs.
 * @package Widgets
 */
class STabbedForm extends CForm {
	
	public $tabs = array();
	protected $activeTab = null;

	/**
	 * @var boolean Dipslay errors summary on each tab.
	 */
	public $summaryOnEachTab = true;

	public function render()
	{
		$result = $this->renderBegin(); 
		$result .= $this->renderElements();
		$result .= $this->renderEnd();

		return $result;
	}

	public function asTabs()
	{
     	$this->render();
		$result = $this->renderBegin();
		 
		if($this->showErrorSummary && ($model=$this->getModel(false))!==null)
		{
			// Display errors summary on each tab.
			$errorSummary = $this->getActiveFormWidget()->errorSummary($model)."\n";

			if ($this->summaryOnEachTab === true)
			{
				foreach ($this->tabs as &$tab)
					$tab = $errorSummary.$tab;
			}
			else
			{
				$result .= $errorSummary;
			}
		}

		// $result .= $this->owner->widget('zii.widgets.jui.CJuiTabs', array(
		// 	'tabs'=>$this->tabs,
		// ), true);
		
		$result .= $this->owner->widget('ext.sidebartabs.SAdminSidebarTabs', array(
			'tabs'=>$this->tabs,
		), true);	
			
		$result .= $this->renderEnd();
		
		return $result; 
	}

	public function renderElements()
	{
		$output='';
		foreach($this->getElements() as $element)
		{
			if (isset($element->title))
			{
				$this->activeTab = $element->title;
			}

			$out=$this->renderElement($element);

			$this->tabs[$this->activeTab] = $out;

			$output .= $out;
		}
		return $output;
	}


}
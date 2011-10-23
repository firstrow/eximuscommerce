<?php
/**
 * Render form using jquery tabs.
 * @package Widgets
 */
class STabbedForm extends CForm {
	
	public $tabs = array();
	protected $activeTab = null;

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

		$result .= $this->owner->widget('zii.widgets.jui.CJuiTabs', array(
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
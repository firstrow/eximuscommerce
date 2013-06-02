<?php
/**
 * Render form using jquery tabs.
 * @package Widgets
 */
class STabbedForm extends CForm {

	/**
	 * @var array list of tabs (tab title=>tab content). Will be
	 * generated from form elements.
	 */
	protected $tabs = array();

	/**
	 * @var array Additional tabs to render.
	 */
	public $additionalTabs = array();

	/**
	 * @var string Widget to render form. zii.widgets.jui.CJuiTabs
	 */
	public $formWidget = 'ext.sidebartabs.SAdminSidebarTabs';

	protected $activeTab = null;

	/**
	 * @var boolean Display errors summary on each tab.
	 */
	public $summaryOnEachTab = false;

	public function render()
	{
		$result  = $this->renderBegin();
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

				// Display error on additional tabs
				foreach($this->additionalTabs as &$tab)
					$tab = $errorSummary.$tab;
			}
			else
				$result = $errorSummary.$result;
		}

		$result .= $this->owner->widget($this->formWidget, array(
			'tabs'=>CMap::mergeArray($this->tabs, $this->additionalTabs),
		), true);

		$result .= $this->renderEnd();

		return $result;
	}

	/**
	 * Renders elements
	 * @return string
	 */
	public function renderElements()
	{
		$output = '';
		foreach($this->getElements() as $element)
		{
			if (isset($element->title))
				$this->activeTab = $element->title;

			$out = $this->renderElement($element);

			$this->tabs[$this->activeTab] = $out;

			$output .= $out;
		}

		return $output;
	}


}
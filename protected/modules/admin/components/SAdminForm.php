<?php

class SAdminForm extends CForm {

	public $showErrorSummary = false;
	public $insertHiddenSubmit = true;

	// public function renderEnd()
	// {
	// 	if ($this->insertHiddenSubmit === true)
	// 		$code = "<input type='submit' style=\"visibility:hidden\">";
	// 	return $code.parent::renderEnd();
	// }

}
<?php

class SAdminForm extends CForm {

	public $insertHiddenSubmit = true;

	public function renderEnd()
	{
		if ($this->insertHiddenSubmit === true)
			$code = "<input type='submit' style=\"visibility:hidden\">";
		return $code.parent::renderEnd();
	}

}
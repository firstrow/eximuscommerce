<?php

class BaseUser extends RWebUser
{

	/**
	 * @var User model
	 */
	private $_model;

	/**
	 * @return string user email
	 */
	public function getEmail()
	{
		$this->_loadModel();
		return $this->_model->email;
	}

	/**
	 * Load user model
	 */
	private function _loadModel()
	{
		if(!$this->_model)
			$this->_model = User::model()->findByPk($this->id);
	}

}

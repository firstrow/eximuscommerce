<?php

class BaseUser extends RWebUser
{

	/**
	 * @var int
	 */
	public $rememberTime = 2622600;

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
	 * @return string username
	 */
	public function getUsername()
	{
		$this->_loadModel();
		return $this->_model->username;
	}

	/**
	 * Load user model
	 */
	private function _loadModel()
	{
		if(!$this->_model)
			$this->_model = User::model()->findByPk($this->id);
	}

	public function getModel()
	{
		$this->_loadModel();
		return $this->_model;
	}
}

<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;

	public function authenticate()
	{
		$record = User::model()->findByAttributes(array('username'=>$this->username));

		if($record === null)
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		else if($record->banned === '1')
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		else if($record->password !== User::encodePassword($this->password))
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		else
		{
			$this->_id = $record->id;
			$record->last_login = date('Y-m-d H:i:s');
			$record->login_ip = Yii::app()->request->userHostAddress;
			$record->save(false);
			$this->errorCode=self::ERROR_NONE;
		}

		return !$this->errorCode;
	}

	public function getId()
	{
		return $this->_id;
	}
}
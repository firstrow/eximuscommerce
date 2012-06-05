<?php

/**
 * Change pass form
 */
class ChangePasswordForm extends CFormModel
{

	/**
	 * @var string
	 */
	public $current_password;

	/**
	 * @var string
	 */
	public $new_password;

	/**
	 * @var User
	 */
	public $user;

	/**
	 * @return array
	 */
	public function rules()
	{
		return array(
			array('current_password, new_password', 'required'),
			array('new_password', 'length', 'min'=>4, 'max'=>40),
			array('current_password', 'validateCurrentPassword'),
		);
	}

	/**
	 * @return array
	 */
	public function attributeLabels()
	{
		return array(
			'current_password' => Yii::t('UsersModule.core', 'Текущий пароль'),
			'new_password' => Yii::t('UsersModule.core', 'Новый пароль'),
		);
	}

	public function validateCurrentPassword()
	{
		if(User::encodePassword($this->current_password) != $this->user->password)
			$this->addError('current_password', Yii::t('UsersModule.core', 'Ошибка проверки текущего пароля'));
	}

}

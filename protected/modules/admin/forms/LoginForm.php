<?php

class LoginForm extends CFormModel
{
	public $username;
	public $password;
	public $rememberMe=false;

	public $_config;

	private $_identity;

	public function getConfig()
	{
		return $config = array(
			'elements'=>array(
				'username'=>array(
					'label'=>Yii::t('AdminModule.admin', 'Логин'),
					'type'=>'text',
					'maxlength'=>32,
				),
				'password'=>array(
					'label'=>Yii::t('AdminModule.admin', 'Пароль'),
					'type'=>'password',
					'maxlength'=>32,
				),
				'rememberMe'=>array(
					'label'=>'Запомнить меня',
					'type'=>'checkbox',
				)
			),

			'buttons'=>array(
				'login'=>array(
					'type'=>'submit',
					'label'=>Yii::t('AdminModule.admin', 'Вход')
				)
			),
		);
	}

	public function rules()
	{
		return array(
			array('username, password', 'required'),
			array('rememberMe', 'boolean'),
			array('password', 'authenticate'),
		);
	}

	public function authenticate($attribute, $params)
	{
		$this->_identity=new UserIdentity($this->username,$this->password);
		if(!$this->_identity->authenticate())
			$this->addError('password',Yii::t('AdminModule.admin', 'Неправильное имя пользователя или пароль.'));
	}

	public function getIdentity()
	{
		return $this->_identity;
	}
}

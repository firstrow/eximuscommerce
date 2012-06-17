<?php

Yii::import('application.modules.core.models.*');
Yii::import('application.modules.users.models.*');

/**
 * Model to configure admin access
 */
class InstallFinishForm extends CFormModel
{
	public $siteName;
	public $adminLogin;
	public $adminEmail;
	public $adminPassword;

	public function rules()
	{
		return array(
			array('siteName, adminLogin, adminEmail, adminPassword', 'required'),
			array('adminEmail', 'email'),
			array('adminLogin', 'length', 'max'=>255),
			array('adminPassword', 'length', 'min'=>4, 'max'=>40),
		);
	}

	/**
	 * @return bool
	 */
	public function install()
	{
		if($this->hasErrors())
			return false;

		$config=require(Yii::getPathOfAlias('application.config').DIRECTORY_SEPARATOR.'main.php');

		$conn=new CDbConnection($config['components']['db']['connectionString'], $config['components']['db']['username'], $config['components']['db']['password']);
		$conn->charset='utf8';
		Yii::app()->setComponent('db', $conn);

		$model=User::model()->findByPk(1);
		$model->username=$this->adminLogin;
		$model->email=$this->adminEmail;
		$model->password=User::encodePassword($this->adminPassword);
		$model->created_at=date('Y-m-d H:i:s');
		$model->last_login=date('Y-m-d H:i:s');
		$model->save(false);

		return true;
	}

	/**
	 * @return array
	 */
	public function attributeLabels()
	{
		return array(
			'siteName'      => Yii::t('InstallModule.core', 'Название сайта'),
			'adminLogin'    => Yii::t('InstallModule.core', 'Логин'),
			'adminEmail'    => Yii::t('InstallModule.core', 'Email'),
			'adminPassword' => Yii::t('InstallModule.core', 'Пароль'),
		);
	}
}

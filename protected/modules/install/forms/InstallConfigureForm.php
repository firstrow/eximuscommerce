<?php

class InstallConfigureForm extends CFormModel
{
	public $siteName;
	public $installDemoData=true;
	public $dbHost='localhost';
	public $dbName;
	public $dbUserName;
	public $dbPassword;
	public $adminLogin;
	public $adminEmail;
	public $adminPassword;

	public function rules()
	{
		return array(
			array('siteName, installDemoData, dbHost, dbName, dbUserName, dbPassword, adminLogin, adminEmail, adminPassword','required'),
			array('dbPassword', 'checkDbConnection'),
			array('adminEmail', 'email'),
			array('adminPassword', 'length', 'min'=>4, 'max'=>40),
		);
	}

	public function checkDbConnection()
	{
		if(!$this->hasErrors())
		{
			$connection=new CDbConnection($this->getDsn(),$this->dbUserName,$this->dbPassword);
			try{
				var_dump($connection->connectionStatus);
			}catch (CDbException $e){
				$this->addError('dbPassword', Yii::t('InstallModule.core','Ошибка подключения к БД'));
			}
		}
	}

	public function getDsn()
	{
		return strtr('mysql:host={host};dbname={db_name}', array(
			'{host}'=>$this->dbHost,
			'{db_name}'=>$this->dbName,
		));
	}

	public function install()
	{
		if($this->hasErrors())
			return false;

		// Read db from dev project;
		// Connect to Db
		// Execute queries
		// Copy images to /uploads/importImages
		// Import CSV files
		// Translate attributes
		// Set attributes filters
		// Set attributes compareable
	}

	public function attributeLabels()
	{
		return array(
			'siteName'        => Yii::t('InstallModule.core', 'Название сайта'),
			'installDemoData' => Yii::t('InstallModule.core', 'Установить демонстрационные данные'),
			'dbHost'          => Yii::t('InstallModule.core', 'Хост'),
			'dbName'          => Yii::t('InstallModule.core', 'Название'),
			'dbUserName'      => Yii::t('InstallModule.core', 'Имя пользователя'),
			'dbPassword'      => Yii::t('InstallModule.core', 'Пароль'),
			'adminLogin'      => Yii::t('InstallModule.core', 'Логин'),
			'adminEmail'      => Yii::t('InstallModule.core', 'Email'),
			'adminPassword'   => Yii::t('InstallModule.core', 'Пароль'),
		);
	}

}

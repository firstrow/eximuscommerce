<?php

Yii::import('application.components.validators.*');
Yii::import('application.modules.core.models.*');
Yii::import('application.modules.csv.components.CsvImporter');


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
				$connection->connectionStatus;
			}catch (CDbException $e){
				$this->addError('dbPassword', Yii::t('InstallModule.core','Ошибка подключения к БД'));
			}
		}
	}

	/**
	 * @return string DSN connection
	 */
	public function getDsn()
	{
		return strtr('mysql:host={host};dbname={db_name}', array(
			'{host}'=>$this->dbHost,
			'{db_name}'=>$this->dbName,
		));
	}

	/**
	 * @return bool
	 */
	public function install()
	{
		if($this->hasErrors())
			return false;

		// Copy images to /uploads/importImages
		// Import CSV files
		// Translate attributes
		// Set attributes filters
		// Set attributes compareable
		$this->importSqlDump();
		$this->writeConnectionSettings();

		$conn=new CDbConnection($this->getDsn(), $this->dbUserName, $this->dbPassword);
		$conn->charset='utf8';
		Yii::app()->setComponent('db', $conn);

		// Activate languages
		Yii::app()->languageManager->setActive();

		if($this->installDemoData)
		{
			$this->importCsvFiles();
		}
	}

	/**
	 * Import default demo data
	 */
	private function importCsvFiles()
	{
		$files = array(
			'computer_sound',
			'laptops',
			'monitors',
			'phones',
			'tablets',
		);

		foreach ($files as $file)
		{
			$importer=new CsvImporter();
			$importer->file=Yii::getPathOfAlias('application.modules.install.data').DIRECTORY_SEPARATOR.$file.'.csv';
			if($importer->validate() && !$importer->hasErrors())
				$importer->import();
		}

		StoreProduct::model()->updateAll(array(
			'is_active'=>1,
		));
	}

	/**
	 * Write connection settings to the main.php
	 */
	private function writeConnectionSettings()
	{
		$configFile=Yii::getPathOfAlias('application.config').DIRECTORY_SEPARATOR.'main.php';
		$content=file_get_contents($configFile);
		$content=preg_replace("/\'connectionString\'\s*\=\>\s*\'.*\'/","'connectionString'=>'{$this->getDsn()}'", $content);
		$content=preg_replace("/\'username\'\s*\=\>\s*\'.*\'/","'username'=>'{$this->dbUserName}'", $content);
		$content=preg_replace("/\'password\'\s*\=\>\s*\'.*\'/","'password'=>'{$this->dbPassword}'", $content);
		file_put_contents($configFile, $content);
	}

	/**
	 * Imports data from sql file
	 */
	private function importSqlDump()
	{
		$sqlDumpPath = Yii::getPathOfAlias('application.modules.install.data').DIRECTORY_SEPARATOR.'dump.sql';
		$sqlRows=preg_split("/--\s*?--.*?\s*--\s*/", file_get_contents($sqlDumpPath));

		$connection=new CDbConnection($this->getDsn(), $this->dbUserName, $this->dbPassword);
		$connection->charset='utf8';
		$connection->active=true;

		$connection->createCommand("SET NAMES 'utf8';");

		foreach($sqlRows as $q)
		{
			$q=trim($q);
			if(!empty($q))
				$connection->createCommand($q)->execute();
		}
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

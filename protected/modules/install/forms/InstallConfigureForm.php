<?php

Yii::import('application.components.validators.*');
Yii::import('application.modules.core.models.*');
Yii::import('application.modules.csv.components.CsvImporter');


class InstallConfigureForm extends CFormModel
{
	public $installDemoData=true;
	public $dbHost='localhost';
	public $dbName;
	public $dbUserName;
	public $dbPassword;

	public function rules()
	{
		return array(
			array('installDemoData, dbHost, dbName, dbUserName','required'),
			array('dbPassword', 'checkDbConnection'),
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

		$this->importSqlDump();
		$this->writeConnectionSettings();

		$conn=new CDbConnection($this->getDsn(), $this->dbUserName, $this->dbPassword);
		$conn->charset='utf8';
		Yii::app()->setComponent('db', $conn);

		// Activate languages
		Yii::app()->languageManager->setActive();

		if($this->installDemoData)
			$this->importCsvFiles();
	}

	/**
	 * Import default demo data
	 */
	private function importCsvFiles()
	{
		$files = array(
			'laptops',
			'computer_sound',
			'monitors',
			'phones',
			'tablets',
		);

		foreach($files as $file)
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
		$sqlDumpPath = Yii::getPathOfAlias('application.data').DIRECTORY_SEPARATOR.'dump.sql';
		$sqlRows=preg_split("/--\s*?--.*?\s*--\s*/", file_get_contents($sqlDumpPath));

		$connection=new CDbConnection($this->getDsn(), $this->dbUserName, $this->dbPassword);
		$connection->charset='utf8';
		$connection->active=true;

		$connection->createCommand("SET NAMES 'utf8';");

		foreach($sqlRows as $q)
		{
			$q=trim($q);
			if(!empty($q))
			{
				if(strpos($q, 'DROP TABLE IF EXISTS')===false)
					$connection->createCommand($q)->execute();
				else
				{
					$lines=preg_split("/(\r?\n)+/", $q);
					$dropQuery=$lines[0];
					array_shift($lines);
					$query=implode('', $lines);

					$connection->createCommand($dropQuery)->execute();
					$connection->createCommand($query)->execute();
				}
			}
		}
	}

	/**
	 * @return array
	 */
	public function attributeLabels()
	{
		return array(
			'siteName'        => Yii::t('InstallModule.core', 'Название сайта'),
			'installDemoData' => Yii::t('InstallModule.core', 'Установить демонстрационные данные'),
			'dbHost'          => Yii::t('InstallModule.core', 'Хост базы данных'),
			'dbName'          => Yii::t('InstallModule.core', 'Имя базы данных'),
			'dbUserName'      => Yii::t('InstallModule.core', 'Имя пользователя базы данных для создания таблиц'),
			'dbPassword'      => Yii::t('InstallModule.core', 'Пароль пользователя'),
		);
	}

    public function getDefaultConnect()
    {
        $configFile=Yii::getPathOfAlias('application.config').DIRECTORY_SEPARATOR.'main.php';
        $configData = include $configFile;

        $this->dbHost = 'localhost';
        $this->dbName = '';
        $this->dbUserName = $configData['components']['db']['username'];
        $this->dbPassword = $configData['components']['db']['password'];

        preg_match_all("/mysql:host=(.+);dbname=(.+)/", $configData['components']['db']['connectionString'], $connectData);
        if (isset($connectData[1][0]) && isset($connectData[2][0])) {
            $this->dbHost = $connectData[1][0];
            $this->dbName = $connectData[2][0];
        }
    }
}

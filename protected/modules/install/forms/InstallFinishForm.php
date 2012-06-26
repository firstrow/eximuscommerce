<?php

Yii::import('application.modules.store.models.*');
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

		// Translate attributes
		$attrsData=array(
			'Rms power'=>'Суммарная мощность',
			'Monitor dimension'=>'Разрешение',
			'Corpus material'=>'Материал',
			'View angle'=>'Угол обзора',
			'Sound type'=>'Тип',
			'Manufacturer'=>'Производитель',
			'Processor manufacturer'=>'Тип процессора',
			'Phone platform'=>'Платформа',
			'Freq'=>'Частота процессора',
			'Phone weight'=>'Вес',
			'Memmory'=>'Объем памяти',
			'Phone display'=>'Диагональ',
			'Memmory type'=>'Тип памяти',
			'Phone camera'=>'Камера',
			'Screen'=>'Диагональ',
			'Tablet screen size'=>'Диагональ',
			'Video'=>'Видео',
			'Memmory size'=>'Объем памяти',
			'Screen dimension'=>'Разрешение',
			'Monitor diagonal'=>'Диагональ',
			'Weight'=>'Вес',
		);

		foreach($attrsData as $key=>$val)
			Yii::app()->db->createCommand("UPDATE StoreAttributeTranslate SET title='{$val}' WHERE title='{$key}'")->execute();

		// Translate product types
		$typesData=array(
			'computer_sound'=>'Акустика',
			'laptop'=>'Ноутбук',
			'monitor'=>'Монитор',
			'phone'=>'Телефон',
			'tablet'=>'Планшет',
		);

		foreach ($typesData as $key=>$val)
			Yii::app()->db->createCommand("UPDATE StoreProductType SET name='{$val}' WHERE name='{$key}'")->execute();

		// Display all attributes on compare page
		Yii::app()->db->createCommand("UPDATE StoreAttribute SET use_in_compare=1")->execute();

		$filters=array(
			'processor_manufacturer', 'screen',
			'corpus_material', 'sound_type',
			'monitor_diagonal',
			'phone_platform',
		);

		foreach ($filters as $name)
			Yii::app()->db->createCommand("UPDATE StoreAttribute SET use_in_filter=1 WHERE name='{$name}'")->execute();

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








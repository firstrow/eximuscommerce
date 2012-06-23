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
			'rms_power'=>'Суммарная мощность',
			'monitor_dimension'=>'Разрешение',
			'corpus_material'=>'Материал',
			'view_angle'=>'Угол обзора',
			'sound_type'=>'Тип',
			'manufacturer'=>'Производитель',
			'processor_manufacturer'=>'Тип процессора',
			'phone_platform'=>'Платформа',
			'freq'=>'Частота процессора',
			'phone_weight'=>'Вес',
			'memmory'=>'Объем памяти',
			'phone_display'=>'Диагональ',
			'memmory_type'=>'Тип памяти',
			'phone_camera'=>'Камера',
			'screen'=>'Диагональ',
			'tablet_screen_size'=>'Диагональ',
			'video'=>'Видео',
			'memmory_size'=>'Объем памяти',
			'screen_dimension'=>'Разрешение',
			'monitor_diagonal'=>'Диагональ',
			'weight'=>'Вес',
		);

		foreach($attrsData as $key=>$val)
		{
			$model=StoreAttribute::model()->findByAttributes(array('name'=>$key));
			if($model)
			{
				$model->title=$val;
				$model->save(false);
			}
		}

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








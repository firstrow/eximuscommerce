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

		$model = User::model()->findByPk(1);

		if(!$model)
			$model = new User();

		// Set user data
		$model->username   = $this->adminLogin;
		$model->email      = $this->adminEmail;
		$model->password   = $model->encodePassword($this->adminPassword);
		$model->created_at = date('Y-m-d H:i:s');
		$model->last_login = date('Y-m-d H:i:s');
		$model->save(false);

		// Create user profile
		$profile = new UserProfile;
		$profile->user_id   = $model->id;
		$profile->full_name = $model->username;
		$profile->save();

		// Translate attributes
		$attrsData=array(
			'Rms power'              => 'Суммарная мощность',
			'Monitor dimension'      => 'Разрешение',
			'Corpus material'        => 'Материал',
			'View angle'             => 'Угол обзора',
			'Sound type'             => 'Тип',
			'Manufacturer'           => 'Производитель',
			'Processor manufacturer' => 'Тип процессора',
			'Phone platform'         => 'Платформа',
			'Freq'                   => 'Частота процессора',
			'Phone weight'           => 'Вес',
			'Memmory'                => 'Объем памяти',
			'Phone display'          => 'Диагональ',
			'Memmory type'           => 'Тип памяти',
			'Phone camera'           => 'Камера',
			'Screen'                 => 'Диагональ',
			'Tablet screen size'     => 'Диагональ',
			'Video'                  => 'Видео',
			'Memmory size'           => 'Объем памяти',
			'Screen dimension'       => 'Разрешение',
			'Monitor diagonal'       => 'Диагональ',
			'Weight'                 => 'Вес',
		);

		foreach($attrsData as $key=>$val)
			Yii::app()->db->createCommand("UPDATE StoreAttributeTranslate SET title='{$val}' WHERE title='{$key}'")->execute();

		// Translate product types
		$typesData=array(
			'laptop'        =>'Ноутбук',
			'computer_sound'=>'Акустика',
			'monitor'       =>'Монитор',
			'phone'         =>'Телефон',
			'tablet'        =>'Планшет',
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

		// Update site settings
		$siteName=Yii::app()->db->quoteValue($this->siteName);
		Yii::app()->db->createCommand("UPDATE SystemSettings t SET t.value={$siteName} WHERE t.key='siteName'")->execute();
		Yii::app()->db->createCommand("UPDATE SystemSettings t SET t.value='12,18,24' WHERE t.key='productsPerPage'")->execute();
		Yii::app()->db->createCommand("UPDATE SystemSettings t SET t.value='30' WHERE t.key='productsPerPageAdmin'")->execute();

		$this->createDiscount();
		$this->createPopularProducts();

		return true;
	}

	/**
	 * Creates test discount for Apple brand
	 */
	protected function createDiscount()
	{
		$manufacturer=Yii::app()->db->createCommand()
			->from('StoreManufacturerTranslate')
			->where(array('and', 'name="Apple"'))
			->queryRow();

		// TODO: Refactor. Check if user install test data.
		if(!$manufacturer)
			return;

		Yii::app()->db->createCommand()->insert('Discount', array(
			'name'      => 'Скидка на всю технику Apple',
			'active'    => 1,
			'sum'       => '5%',
			'start_date'=> date('Y-m-d H:i:s'),
			'end_date'  => ((int)date('Y')+1).'-01-01 12:00:00',
		));
		$discountId=Yii::app()->db->getLastInsertID();

		Yii::app()->db->createCommand()->insert('DiscountManufacturer', array(
			'discount_id'     => $discountId,
			'manufacturer_id' => $manufacturer['object_id'],
		));

		$categories=Yii::app()->db->createCommand()
			->from('StoreCategory')
			->queryAll();

		foreach($categories as $c)
		{
			Yii::app()->db->createCommand()->insert('DiscountCategory', array(
				'discount_id'=>$discountId,
				'category_id'=>$c['id'],
			));
		}
	}

	/**
	 * Set initial view for some product to display then in `Popular products` block
	 */
	public function createPopularProducts()
	{
		$urls=array(
			'apple-macbook-pro-15-late-2011',
			'htc-one-xl',
			'nokia-n9',
			'apple-ipad-2-16gb-wi-fi--3g',
		);

		$n=5;
		foreach ($urls as $url)
		{
			Yii::app()->db->createCommand()->update('StoreProduct',array(
				'views_count'=>$n
			),'url=:url', array(':url'=>$url));
			++$n;
		}

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








<?php

/**
 * This is the model class for table "SystemModules".
 *
 * The followings are the available columns in table 'SystemModules':
 * @property integer $id
 * @property string $name
 * @property integer $enabled Allow access by url.
 */
class SystemModules extends BaseModel
{
	/**
	 * Cache enabled modules for request
	 */
	protected static $cache = null;

	/**
	 * Cache all modules for request
	 * @var null
	 */
	protected static $cacheAll = null;

	/**
	 * Module info
	 */
	protected $info = null;

	/**
	 * Returns the static model of the specified AR class.
	 * @return SystemModules the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'SystemModules';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, enabled', 'required'),
			array('enabled', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('name, enabled', 'safe', 'on'=>'search'),
		);
	}


	public function scopes()
	{
		return array(
			'enabled'=>array(
				'condition'=>'enabled=1'
			),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => Yii::t('CoreModule.core', 'Название'),
			'enabled' => Yii::t('CoreModule.core', 'Активен'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('enabled',$this->enabled);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Load enabled modules and cache for current request
	 * @return array Enabled modules
	 */
	public static function getEnabled()
	{
		if (self::$cache)
			return self::$cache;

		$cr = new CDbCriteria;
		$cr->select = 'name';

		self::$cache = SystemModules::model()
			->enabled()
			->findAll($cr);

		return self::$cache;
	}

	/**
	 * @return array All installed modules names
	 */
	public static function getInstalled()
	{
		if (self::$cacheAll)
			return self::$cacheAll;

		$cr = new CDbCriteria;
		$cr->select = 'name';

		self::$cacheAll = SystemModules::model()
			->findAll($cr);

		return self::$cacheAll;
	}

	/**
	 * Get not installed modules
	 * @return array List of modules available to install.
	 */
	public function getAvailable()
	{
		$result = array();
		$files = glob(Yii::getPathOfAlias('application.modules.*') . '/*/config/info.php');

		if (!sizeof($files))
			return array();

		foreach ($files as $file)
		{
			$parts = explode(DIRECTORY_SEPARATOR, $file);
			$moduleName = $parts[sizeof($parts)-3];
			if (!self::isModuleInstalled($moduleName))
				$result[$moduleName] = require($file);
		}

		return $result;
	}

	/**
	 * Check if module is installed
	 * @param string $name
	 * @return boolean
	 */
	public static function isModuleInstalled($name)
	{
		return (boolean) SystemModules::model()
			->count('name=:name', array(':name'=>$name));
	}

	/**
	 * Install module
	 * @param type $name module name
	 * @return boolean
	 */
	public function install($name)
	{
		$model = new SystemModules;
		$model->name = $name;
		$model->enabled = true;

		try {
			Yii::trace('Module installed');
			$model->save();
		} catch(Exception $e) {
			Yii::trace('Error installing module');
			return false;
		}

		return true;
	}

	/**
	 * Load module description file
	 * @param string $name module name
	 * @return array
	 */
	public static function loadInfoFile($name = null)
	{
		return require(Yii::getPathofAlias('application.modules.'.$name.'.config.info').'.php');
	}

	/**
	 * Get module description
	 * @return string
	 */
	public function getInfo()
	{
		if ($this->info)
			return $this->info;
		$this->info = (object) self::loadInfoFile($this->name);

		if(!isset($this->info->config_url))
			$this->info->config_url = false;

		return $this->info;
	}

}
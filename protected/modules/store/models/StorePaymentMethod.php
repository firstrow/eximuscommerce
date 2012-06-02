<?php

Yii::import('application.modules.store.models.StorePaymentMethodTranslate');

/**
 * This is the model class for table "StorePaymentMethod".
 *
 * The followings are the available columns in table 'StorePaymentMethod':
 * @property integer $id
 * @property integer $currency_id
 * @property string $name
 * @property string $description
 * @property string $payment_system
 * @property integer $active
 * @property integer $position
 */
class StorePaymentMethod extends BaseModel
{

	/**
	 * @var string
	 */
	public $translateModelName = 'StorePaymentMethodTranslate';

	/**
	 * @var string
	 */
	public $name;

	/**
	 * @var string
	 */
	public $description;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StorePaymentMethod the static model class
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
		return 'StorePaymentMethod';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name, currency_id', 'required'),
			array('active, position', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('description', 'safe'),
			array('payment_system', 'safe'),
			// Search
			array('id, name, description, active', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'pm_translate' => array(self::HAS_ONE, $this->translateModelName, 'object_id'),
		);
	}

	/**
	 * @return array
	 */
	public function behaviors()
	{
		return array(
			'STranslateBehavior'=>array(
				'class'=>'ext.behaviors.STranslateBehavior',
				'relationName'=>'pm_translate',
				'translateAttributes'=>array(
					'name',
					'description',
				),
			),
		);
	}

	/**
	 * @return array
	 */
	public function scopes()
	{
		$alias = $this->getTableAlias();
		return array(
			'active'              => array('order'=>$alias.'.active=1'),
			'orderByPosition'     => array('order'=>$alias.'.position ASC'),
			'orderByPositionDesc' => array('order'=>$alias.'.position DESC'),
			'orderByName'         => array('order'=>$alias.'.name ASC'),
			'orderByNameDesc'     => array('order'=>$alias.'.name DESC'),
		);
	}

	/**
	 * Before save event
	 */
	public function beforeSave()
	{
		if($this->position == '')
		{
			$max = StorePaymentMethod::model()->orderByPositionDesc()->find();
			if($max)
				$this->position = (int)$max->position + 1;
			else
				$this->position = 0;
		}
		return parent::beforeSave();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'             => 'ID',
			'name'           => Yii::t('StoreModule.admin', 'Название'),
			'description'    => Yii::t('StoreModule.admin', 'Описание'),
			'active'         => Yii::t('StoreModule.admin', 'Активен'),
			'position'       => Yii::t('StoreModule.admin', 'Позиция'),
			'payment_system' => Yii::t('StoreModule.admin', 'Система оплаты'),
			'currency_id'    => Yii::t('StoreModule.admin', 'Валюта'),
		);
	}

	/**
	 * @return array of available payment systems. e.g array(id=>name)
	 */
	public function getPaymentSystemsArray()
	{
		$result=array();
		$systems=new SPaymentSystemManager;
		foreach($systems->getSystems() as $system)
			$result[(string)$system->id]=$system->name;
		return $result;
	}

	/**
	 * Renders form display on the order view page
	 */
	public function renderPaymentForm(Order $order)
	{
		if($this->payment_system)
		{
			$manager=new SPaymentSystemManager;
			$system = $manager->getSystemClass($this->payment_system);
			return $system->renderPaymentForm($this, $order);
		}
	}

	/**
	 * @return null|BasePaymentSystem
	 */
	public function getPaymentSystemClass()
	{
		if($this->payment_system)
		{
			$manager=new SPaymentSystemManager;
			return $manager->getSystemClass($this->payment_system);
		}
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->with=array('pm_translate');

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('active',$this->active);

		$sort=new CSort;
		$sort->defaultOrder = $this->getTableAlias().'.position ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort
		));
	}
}
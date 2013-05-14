<?php

/**
 * This is the model class for table "StoreDeliveryMethods".
 *
 * The followings are the available columns in table 'StoreDeliveryMethods':
 * @property integer $id
 * @property string $name
 * @property float $price
 * @property float $free_from
 * @property boolean $active
 * @property string $description
 * @property integer $position
 */
class StoreDeliveryMethod extends BaseModel
{

	/**
	 * @var array
	 */
	public $_payment_methods;

	/**
	 * @var string
	 */
	public $name;

	/**
	 * @var string
	 */
	public $description;

	/**
	 * @var string
	 */
	public $translateModelName = 'StoreDeliveryMethodTranslate';

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StoreDeliveryMethod the static model class
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
		return 'StoreDeliveryMethod';
	}

	/**
	 * @return array
	 */
	public function scopes()
	{
		$alias = $this->getTableAlias();
		return array(
			'active'              => array('condition'=>$alias.'.active=1'),
			'orderByPosition'     => array('order'=>$alias.'.position ASC'),
			'orderByPositionDesc' => array('order'=>$alias.'.position DESC'),
			'orderByName'         => array(
				'with'=>'dm_translate',
				'order'=>'dm_translate.name ASC'
			),
			'orderByNameDesc'     => array(
				'with'=>'dm_translate',
				'order'=>'dm_translate.name DESC'
			),
		);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name', 'required'),
			array('position', 'numerical', 'integerOnly'=>true),
			array('price, free_from', 'numerical'),
			array('active', 'boolean'),
			array('payment_methods', 'validatePaymentMethods'),
			array('name', 'length', 'max'=>255),
			array('description', 'type', 'type'=>'string'),

			array('id, name, description, position', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array
	 */
	public function relations()
	{
		return array(
			'categorization' => array(self::HAS_MANY, 'StoreDeliveryPayment', 'delivery_id'),
			'paymentMethods' => array(self::HAS_MANY, 'StorePaymentMethod', array('payment_id'=>'id'), 'through'=>'categorization', 'order'=>'paymentMethods.position'),
			'dm_translate'   => array(self::HAS_ONE, 'StoreDeliveryMethodTranslate', 'object_id'),
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
				'relationName'=>'dm_translate',
				'translateAttributes'=>array(
					'name',
					'description',
				),
			),
		);
	}

	/**
	 * Validate payment method exists
	 * @param $attr
	 * @return mixed
	 */
	public function validatePaymentMethods($attr)
	{
		if(!is_array($this->$attr))
			return;

		foreach($this->$attr as $id)
		{
			if(StorePaymentMethod::model()->countByAttributes(array('id'=>$id)) == 0)
				$this->addError($attr, Yii::t('StoreModule.core', 'Ошибка проверки способка оплаты.'));
		}
	}

	/**
	 * Before save event
	 */
	public function beforeSave()
	{
		if($this->position == '')
		{
			$max = StoreDeliveryMethod::model()->orderByPositionDesc()->find();
			if($max)
				$this->position = (int)$max->position + 1;
			else
				$this->position = 0;
		}
		return parent::beforeSave();
	}

	/**
	 * After save event
	 */
	public function afterSave()
	{
		// Clear payment relations
		StoreDeliveryPayment::model()->deleteAllByAttributes(array('delivery_id'=>$this->id));

		foreach($this->payment_methods as $pid)
		{
			$model = new StoreDeliveryPayment;
			$model->delivery_id = $this->id;
			$model->payment_id = $pid;
			$model->save(false);
		}

		return parent::afterSave();
	}

	/**
	 * @param $data array ids of payment methods
	 */
	public function setPayment_methods($data)
	{
		$this->_payment_methods = $data;
	}

	/**
	 * @return array
	 */
	public function getPayment_methods()
	{
		if($this->_payment_methods)
			return $this->_payment_methods;

		$this->_payment_methods = array();
		foreach($this->categorization as $row)
			$this->_payment_methods[] = $row->payment_id;
		return $this->_payment_methods;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'               => 'ID',
			'name'             => Yii::t('StoreModule.core', 'Название'),
			'price'            => Yii::t('StoreModule.core', 'Цена'),
			'free_from'        => Yii::t('StoreModule.core', 'Бесплатен от'),
			'active'           => Yii::t('StoreModule.core', 'Активен'),
			'description'      => Yii::t('StoreModule.core', 'Описание'),
			'position'         => Yii::t('StoreModule.core', 'Позиция'),
			'payment_methods'  => Yii::t('StoreModule.core', 'Способы оплаты'),
		);
	}

	/**
	 * @return string order used delivery method
	 */
	public function countOrders()
	{
		Yii::import('orders.models.*');
		return Order::model()->countByAttributes(array('delivery_id'=>$this->id));
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->with=array('dm_translate');

		$criteria->compare('t.id',$this->id);
		$criteria->compare('dm_translate.name',$this->name,true);
		$criteria->compare('dm_translate.description',$this->description,true);
		$criteria->compare('t.position',$this->position);
		$criteria->compare('t.active',$this->active);

		$sort=new CSort;
		$sort->defaultOrder = $this->getTableAlias().'.position ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}
}
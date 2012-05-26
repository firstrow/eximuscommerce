<?php

/**
 * This is the model class for table "OrderProduct".
 *
 * The followings are the available columns in table 'OrderProduct':
 * @property integer $id
 * @property integer $order_id
 * @property integer $product_id
 * @property integer $configurable_id
 * @property string $name
 * @property string $configurable_name Name of configurable product
 * @property string $configurable_data same as $variants but store attr=>value for configurable product
 * @property string $variants Key/value array of selected variants. E.g: Color/Green, Size/Large
 * @property integer $quantity
 * @property string $sku
 * @property float $price
 */
class OrderProduct extends BaseModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrderProduct the static model class
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
		return 'OrderProduct';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('id, order_id, product_id, configurable_id, name, quantity, sku, price', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'order'=>array(self::BELONGS_TO, 'Order', 'order_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'              => 'ID',
			'order_id'        => Yii::t('OrdersModule.core', 'Заказы'),
			'product_id'      => Yii::t('OrdersModule.core', 'Продукт'),
			'configurable_id' => Yii::t('OrdersModule.core', 'Конфигурация'),
			'name'            => Yii::t('OrdersModule.core', 'Название'),
			'quantity'        => Yii::t('OrdersModule.core', 'Количество'),
			'sku'             => Yii::t('OrdersModule.core', 'Артикул'),
			'price'           => Yii::t('OrdersModule.core', 'Цена'),
		);
	}

	/**
	 * @return boolean
	 */
	public function afterSave()
	{
		$this->order->updateTotalPrice();
		return parent::afterSave();
	}

	public function afterDelete()
	{
		if($this->order)
			$this->order->updateTotalPrice();
		return parent::afterDelete();
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('configurable_id',$this->configurable_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('sku',$this->sku,true);
		$criteria->compare('price',$this->price);

		return new CActiveDataProvider($this, array(
			'criteria'   => $criteria,
			'pagination' => false // By default disable pagination to show all products in amdin panel
		));
	}

	/**
	 * Render full name to present product on order view
	 * @return string
	 */
	public function getRenderFullName($appendConfigurableName=true)
	{
		$result = $this->name;

		if(!empty($this->configurable_name) && $appendConfigurableName)
			$result .= '<br/>'.$this->configurable_name;

		$variants = unserialize($this->variants);

		if($this->configurable_data!=='')
			$this->configurable_data=unserialize($this->configurable_data);

		if(!is_array($variants))
			$variants=array();
		if(!is_array($this->configurable_data))
			$this->configurable_data=array();

		$variants=array_merge($variants,$this->configurable_data);

		if(!empty($variants))
		{
			foreach($variants as $key=>$value)
			{
				$result .= "<br/> - {$key}: {$value}";
			}
		}

		return $result;
	}
}
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'order_id' => 'Order',
			'product_id' => 'Product',
			'configurable_id' => 'Configurable',
			'name' => 'Name',
			'quantity' => 'Quantity',
			'sku' => 'Sku',
			'price' => 'Price',
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
		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('configurable_id',$this->configurable_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('sku',$this->sku,true);
		$criteria->compare('price',$this->price);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
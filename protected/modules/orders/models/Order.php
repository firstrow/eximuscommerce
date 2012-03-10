<?php

/**
 * This is the model class for table "Order".
 *
 * The followings are the available columns in table 'Order':
 * @property integer $id
 * @property integer $user_id
 * @property integer $delivery_id
 * @property float $delivery_price
 * @property float $total_price
 * @property integer $status_id
 * @property integer $paid
 * @property string $user_name
 * @property string $user_email
 * @property string $user_address
 * @property string $user_phone
 * @property string $user_comment
 * @property string $ip_address
 * @property string $created
 * @property string $updated
 */
class Order extends BaseModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Order the static model class
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
		return 'Order';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('user_name, user_email, delivery_id', 'required', 'on'=>'update'),
			array('user_name, user_email', 'length', 'max'=>100),
			array('user_phone', 'length', 'max'=>30),
			array('user_email', 'email'),
			array('user_comment', 'length', 'max'=>500),
			array('user_address', 'length', 'max'=>255),
			array('delivery_id', 'validateDelivery'),

			array('id, user_id, delivery_id, delivery_price, total_price, status_id, paid, user_name, user_email, user_address, user_phone, user_comment, ip_address, created, updated', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'             => 'ID',
			'user_id'        => Yii::t('OrdersModule.core','Пользователь'),
			'delivery_id'    => Yii::t('OrdersModule.core','Способ доставки'),
			'delivery_price' => Yii::t('OrdersModule.core','Цена доставки'),
			'total_price'    => Yii::t('OrdersModule.core','Общая сумма'),
			'status_id'      => Yii::t('OrdersModule.core','Статус'),
			'paid'           => Yii::t('OrdersModule.core','Оплачен'),
			'user_name'      => Yii::t('OrdersModule.core','Имя'),
			'user_email'     => Yii::t('OrdersModule.core','Email'),
			'user_address'   => Yii::t('OrdersModule.core','Адрес доставки'),
			'user_phone'     => Yii::t('OrdersModule.core','Телефон'),
			'user_comment'   => Yii::t('OrdersModule.core','Комментарий пользователя'),
			'ip_address'     => Yii::t('OrdersModule.core','IP адрес'),
			'created'        => Yii::t('OrdersModule.core','Дата создания'),
			'updated'        => Yii::t('OrdersModule.core','Дата обновления'),
		);
	}

	/**
	 * Check if delivery method exists
	 */
	public function validateDelivery()
	{
		if(StoreDeliveryMethod::model()->countByAttributes(array('id'=>$this->delivery_id)) == 0)
			$this->addError('delivery_id', Yii::t('OrdersModule.core', 'Необходимо выбрать способ доставки.'));
	}

	/**
	 * @return bool
	 */
	public function beforeSave()
	{
		if($this->isNewRecord)
		{
			$this->ip_address = Yii::app()->request->userHostAddress;
			$this->created = date('Y-m-d H:i:s');
		}
		$this->updated = date('Y-m-d H:i:s');

		return parent::beforeSave();
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('delivery_id',$this->delivery_id);
		$criteria->compare('delivery_price',$this->delivery_price);
		$criteria->compare('total_price',$this->total_price);
		$criteria->compare('status_id',$this->status_id);
		$criteria->compare('paid',$this->paid);
		$criteria->compare('user_name',$this->user_name,true);
		$criteria->compare('user_email',$this->user_email,true);
		$criteria->compare('user_address',$this->user_address,true);
		$criteria->compare('user_phone',$this->user_phone,true);
		$criteria->compare('user_comment',$this->user_comment,true);
		$criteria->compare('ip_address',$this->ip_address,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
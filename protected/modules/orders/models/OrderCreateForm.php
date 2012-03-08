<?php

Yii::import('store.models.StoreDeliveryMethod');

/**
 * Used data form. Used in cart to create new order.
 */
class OrderCreateForm extends CFormModel
{
	public $name;
	public $email;
	public $phone;
	public $address;
	public $comment;
	public $delivery_id;

	/**
	 * Validation
	 * @return array
	 */
	public function rules()
	{
		return array(
			array('name, email', 'required'),
			array('email', 'email'),
			array('comment', 'length', 'max'=>'500'),
			array('address', 'length', 'max'=>'255'),
			array('email', 'length', 'max'=>'100'),
			array('phone', 'length', 'max'=>'30'),
			array('delivery_id', 'validateDelivery'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'name'        => Yii::t('OrdersModule.core', 'Имя'),
			'email'       => Yii::t('OrdersModule.core', 'Email'),
			'comment'     => Yii::t('OrdersModule.core', 'Комментарий'),
			'address'     => Yii::t('OrdersModule.core', 'Адрес доставки'),
			'phone'       => Yii::t('OrdersModule.core', 'Номер телефона'),
			'delivery_id' => Yii::t('OrdersModule.core', 'Способ доставки'),
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
}

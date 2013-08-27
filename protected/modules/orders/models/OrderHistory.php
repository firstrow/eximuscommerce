<?php

/**
 * This is the model class for table "OrderHistory".
 *
 * The followings are the available columns in table 'OrderHistory':
 * @property integer $id
 * @property integer $order_id
 * @property integer $user_id
 * @property string $username
 * @property string $handler
 * @property string $data_before
 * @property string $data_after
 * @property string $created
 */
class OrderHistory extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrderHistory the static model class
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
		return 'OrderHistory';
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'          => 'ID',
			'order_id'    => 'Order',
			'user_id'     => 'User',
			'username'    => 'Username',
			'handler'     => 'Handler',
			'data_before' => 'Data Before',
			'data_after'  => 'Data After',
			'created'     => 'Created',
		);
	}

	/**
	 * @return array
	 */
	public function getDataBefore()
	{
		if($this->handler === 'attributes')
			return $this->prepareData($this->data_before);
		else
			return unserialize($this->data_before);
	}

	/**
	 * @return array
	 */
	public function getDataAfter()
	{
		if($this->handler === 'attributes')
			return $this->prepareData($this->data_after);
		else
			return unserialize($this->data_after);
	}

	/**
	 * @param $data
	 * @return array
	 */
	public function prepareData($data)
	{
		$order  = new Order;
		$result = array();
		$data   = unserialize($data);

		foreach ($data as $key=>$val)
		{
			if($key==='paid')
			{
				if($val)
					$val=Yii::t('OrdersModule.admin','Да');
				else
					$val=Yii::t('OrdersModule.admin','Нет');
			}
			$result[$order->getAttributeLabel($key)] = $val;
		}

		return $result;
	}
}
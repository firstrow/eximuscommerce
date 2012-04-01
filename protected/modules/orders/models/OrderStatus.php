<?php

/**
 * This is the model class for table "OrderStatus".
 *
 * The followings are the available columns in table 'OrderStatus':
 * @property integer $id
 * @property string $name
 * @property integer $position
 */
class OrderStatus extends BaseModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrderStatus the static model class
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
		return 'OrderStatus';
	}

	/**
	 * @return array
	 */
	public function scopes()
	{
		$alias = $this->getTableAlias();
		return array(
			'orderByPosition'     => array('order'=>$alias.'.position ASC'),
			'orderByPositionDesc' => array('order'=>$alias.'.position DESC'),
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
			array('name', 'length', 'max'=>255),
			array('id, name, position', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'       => 'ID',
			'name'     => Yii::t('OrdersModule.admin','Название'),
			'position' => Yii::t('OrdersModule.admin','Позиция'),
		);
	}

	public function beforeSave()
	{
		if($this->position == '')
		{
			$max = OrderStatus::model()->orderByPositionDesc()->find();
			if($max)
				$this->position = (int)$max->position + 1;
			else
				$this->position = 0;
		}
		return parent::beforeSave();
	}

	/**
	 * @return bool
	 */
	public function countOrders()
	{
		return Order::model()->countByAttributes(array('status_id'=>$this->id));
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
		$criteria->compare('position',$this->position);

		$sort=new CSort;
		$sort->defaultOrder = $this->getTableAlias().'.position ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort
		));
	}
}
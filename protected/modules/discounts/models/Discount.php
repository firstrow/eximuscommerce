<?php

/**
 * Main discounts model
 * This is the model class for table "Discount".
 *
 * The followings are the available columns in table 'Discount':
 * @property integer $id
 * @property string $name
 * @property integer $active
 * @property string $sum
 * @property integer $start_date
 * @property integer $end_date
 * @property string $roles json encoded
 */
class Discount extends BaseModel
{
	/**
	 * @var array ids of categories to apply discount
	 */
	protected $_categories;

	/**
	 * @var array ids of manufacturers to apply discount
	 */
	protected $_manufacturers;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Discount the static model class
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
		return 'Discount';
	}

	/**
	 * @return array
	 */
	public function scopes()
	{
		$alias = $this->getTableAlias();
		return array(
			'orderByName'=>array('order'=>$alias.'.name ASC'),
			'activeOnly'=>array('condition'=>$alias.'.active=1'),
			'applyDate'=>array(
				'condition'=>'start_date <= :now AND end_date >= :now',
				'params'=>array(':now'=>date('Y-m-d H:i:s')),
			),
		);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name, sum, start_date, end_date', 'required'),
			array('active', 'boolean'),
			array('name', 'length', 'max'=>255),
			array('sum', 'length', 'max'=>10),
			array('manufacturers, categories, userRoles', 'type', 'type'=>'array'),
			array('start_date, end_date', 'date','format'=>'yyyy-M-d H:m:s'),

			array('id, name, active, sum, start_date, end_date', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array
	 */
	public function getCategories()
	{
		if(is_array($this->_categories))
			return $this->_categories;

		$this->_categories = Yii::app()->db->createCommand()
			->select('category_id')
			->from('DiscountCategory')
			->where('discount_id=:id', array(':id'=>$this->id))
			->queryColumn();

		return $this->_categories;
	}

	/**
	 * @param array $data
	 */
	public function setCategories(array $data)
	{
		$this->_categories = $data;
	}

	/**
	 * @return array
	 */
	public function getUserRoles()
	{
		return json_decode($this->roles);
	}

	/**
	 * @param array $roles
	 */
	public function setUserRoles(array $roles)
	{
		$this->roles = json_encode($roles);
	}

	/**
	 * @return array
	 */
	public function getManufacturers()
	{
		if(is_array($this->_manufacturers))
			return $this->_manufacturers;

		$this->_manufacturers = Yii::app()->db->createCommand()
			->select('manufacturer_id')
			->from('DiscountManufacturer')
			->where('discount_id=:id', array(':id'=>$this->id))
			->queryColumn();

		return $this->_manufacturers;
	}

	/**
	 * @param array $data
	 */
	public function setManufacturers(array $data)
	{
		$this->_manufacturers = $data;
	}

	/**
	 * After save event
	 */
	public function afterSave()
	{
		$this->clearRelations();

		// Process manufacturers
		if(!empty($this->_manufacturers))
		{
			foreach($this->_manufacturers as $id)
			{
				Yii::app()->db->createCommand()->insert('DiscountManufacturer', array(
					'discount_id'=>$this->id,
					'manufacturer_id'=>$id,
				));
			}
		}

		// Process categories
		if(!empty($this->_categories))
		{
			foreach($this->_categories as $id)
			{
				Yii::app()->db->createCommand()->insert('DiscountCategory', array(
					'discount_id'=>$this->id,
					'category_id'=>$id,
				));
			}
		}

		return parent::afterSave();
	}

	public function afterDelete()
	{
		$this->clearRelations();
	}

	/**
	 * Clear discount manuacturer and category
	 */
	public function clearRelations()
	{
		Yii::app()->db->createCommand()->delete('DiscountManufacturer', 'discount_id=:id', array(':id'=>$this->id));
		Yii::app()->db->createCommand()->delete('DiscountCategory', 'discount_id=:id', array(':id'=>$this->id));
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'            => 'ID',
			'name'          => Yii::t('DiscountsModule.core', 'Название'),
			'active'        => Yii::t('DiscountsModule.core', 'Активен'),
			'sum'           => Yii::t('DiscountsModule.core', 'Скидка'),
			'start_date'    => Yii::t('DiscountsModule.core', 'Дата начала'),
			'end_date'      => Yii::t('DiscountsModule.core', 'Дата окончания'),
			'manufacturers' => Yii::t('DiscountsModule.core', 'Производители'),
			'userRoles'     => Yii::t('DiscountsModule.core', 'Группы пользователей'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('t.active',$this->active);
		$criteria->compare('t.sum',$this->sum,true);
		$criteria->compare('t.start_date',$this->start_date, true);
		$criteria->compare('t.end_date',$this->end_date, true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
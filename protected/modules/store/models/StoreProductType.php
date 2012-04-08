<?php

/**
 * Store product types
 * This is the model class for table "StoreProductType".
 *
 * The followings are the available columns in table 'StoreProductType':
 * @property integer $id
 * @property string $name
 * @property string $categories_preset
 * @property int $main_category preset
 */
class StoreProductType extends BaseModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StoreProductType the static model class
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
		return 'StoreProductType';
	}

	public function scopes()
	{
		$alias = $this->getTableAlias(true);
		return array(
			'orderByName'=>array('order'=>$alias.'.name'),
		);
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>255),

			array('id, name', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'attributeRelation'           => array(self::HAS_MANY, 'StoreTypeAttribute', 'type_id'),
			'storeAttributes'             => array(self::HAS_MANY, 'StoreAttribute', array('attribute_id'=>'id'), 'through'=>'attributeRelation', 'scopes'=>'applyTranslateCriteria'),
			'storeConfigurableAttributes' => array(self::HAS_MANY, 'StoreAttribute', array('attribute_id'=>'id'), 'through'=>'attributeRelation', 'condition'=>'use_in_variants=1'),
			'productsCount'               => array(self::STAT, 'StoreProduct', 'type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'   => 'ID',
			'name' => Yii::t('StoreModule.admin','Название'),
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Clear and set type attributes
	 * @param $attributes array of attributes id. array(1,3,5)
	 * @return mixed
	 */
	public function useAttributes($attributes)
	{
		// Clear all relations
		StoreTypeAttribute::model()->deleteAllByAttributes(array('type_id'=>$this->id));

		if (empty($attributes))
			return false;

		foreach($attributes as $attribute_id)
		{
			if($attribute_id)
			{
				$record = new StoreTypeAttribute;
				$record->type_id = $this->id;
				$record->attribute_id = $attribute_id;
				$record->save(false);
			}
		}
	}

	public function afterDelete()
	{
		// Clear type attribute relations
		StoreTypeAttribute::model()->deleteAllByAttributes(array('type_id'=>$this->id));
		return parent::afterDelete();
	}

	public function __toString()
	{
		return $this->name;
	}
}
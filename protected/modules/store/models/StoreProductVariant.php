<?php

/**
 * This is the model class for table "StoreProductVariant".
 *
 * The followings are the available columns in table 'StoreProductVariant':
 * @property integer $id
 * @property integer $attribute_id
 * @property integer $option_id
 * @property integer $product_id
 * @property float $price
 * @property integer $price_type
 * @property string $sku
 */
class StoreProductVariant extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StoreProductVariant the static model class
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
		return 'StoreProductVariant';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('attribute_id, option_id, product_id, price, price_type', 'required'),
			array('attribute_id, option_id, product_id, price_type', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('sku', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, attribute_id, option_id, product_id, price, price_type, sku', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'attribute' => array(self::BELONGS_TO, 'StoreAttribute', 'attribute_id'),
			'option'    => array(self::BELONGS_TO, 'StoreAttributeOption', 'option_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'attribute_id' => 'Attribute',
			'option_id' => 'Option',
			'product_id' => 'Product',
			'price' => 'Price',
			'price_type' => 'Price Type',
			'sku' => 'Sku',
		);
	}

}
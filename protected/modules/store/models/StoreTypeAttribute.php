<?php

/**
 * Store type attributes
 * This is the model class for table "StoreTypeAttribute".
 *
 * The followings are the available columns in table 'StoreTypeAttribute':
 * @property integer $id
 * @property integer $type_id
 * @property integer $attribute_id
 */
class StoreTypeAttribute extends BaseModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StoreTypeAttribute the static model class
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
		return 'StoreTypeAttribute';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'attribute'=>array(self::BELONGS_TO, 'StoreAttribute', 'attribute_id'),
		);
	}


}
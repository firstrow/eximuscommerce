<?php

/**
 * This is the model class for table "StoreRelatedProduct".
 *
 * The followings are the available columns in table 'StoreRelatedProduct':
 * @property integer $id
 * @property integer $product_id
 * @property integer $related_id
 */
class StoreRelatedProduct extends BaseModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return StoreRelatedProduct the static model class
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
		return 'StoreRelatedProduct';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}


}
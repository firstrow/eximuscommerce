<?php

/**
 * This is the model class for table "StoreProductCategoryRef".
 *
 * The followings are the available columns in table 'StoreProductCategoryRef':
 * @property integer $id
 * @property integer $category
 * @property integer $product
 * @property boolean $is_main
 */
class StoreProductCategoryRef extends BaseModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return StoreProductCategoryRef the static model class
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
		return 'StoreProductCategoryRef';
	}

}
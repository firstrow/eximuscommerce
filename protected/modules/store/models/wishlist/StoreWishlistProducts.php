<?php

/**
 * This is the model class for table "StoreWishlistProducts".
 *
 * The followings are the available columns in table 'StoreWishlistProducts':
 * @property integer $id
 * @property integer $wishlist_id
 * @property integer $product_id
 * @property integer $user_id
 */
class StoreWishlistProducts extends BaseModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StoreWishlistProducts the static model class
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
		return 'StoreWishlistProducts';
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'wishlist_id' => 'Wishlist',
			'product_id' => 'Product',
		);
	}

}
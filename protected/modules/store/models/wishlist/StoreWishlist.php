<?php

Yii::import('application.modules.store.models.wishlist.StoreWishlistProducts');

/**
 * This is the model class for table "StoreWishlist".
 *
 * The followings are the available columns in table 'StoreWishlist':
 * @property integer $id
 * @property string $key
 * @property integer $user_id
 */
class StoreWishlist extends BaseModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StoreWishlist the static model class
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
		return 'StoreWishlist';
	}

	/**
	 * @param $user_id
	 */
	public function create($user_id)
	{
		$model = new StoreWishlist;
		$model->user_id=$user_id;
		$model->key=$this->createSecretKey();
		$model->save(false);
		return;
	}

	/**
	 * @param array $ids
	 */
	public function setIds(array $ids)
	{
		StoreWishlistProducts::model()->deleteAllByAttributes(array(
			'wishlist_id'=>$this->id
		));

		if(!empty($ids))
		{
			foreach($ids as $id)
			{
				$record = new StoreWishlistProducts;
				$record->wishlist_id=$this->id;
				$record->product_id=$id;
				$record->user_id=$this->user_id;
				$record->save(false);
			}
		}
	}

	public function afterDelete()
	{
		$this->setIds(array());
		parent::afterDelete();
	}

	/**
	 * get products ids save in the current wishlist
	 */
	public function getIds()
	{
		return Yii::app()->db->createCommand()
			->select('product_id')
			->from(StoreWishlistProducts::model()->tableName())
			->where('wishlist_id=:id', array(':id'=>$this->id))
			->queryColumn();
	}

	/**
	 * Create unique key to view orders
	 * @param int $size
	 * @return string
	 */
	public function createSecretKey($size=10)
	{
		$result = '';
		$chars = '1234567890qweasdzxcrtyfghvbnuioplkjnm';
		while(mb_strlen($result,'utf8') < $size)
			$result .= mb_substr($chars, rand(0, mb_strlen($chars,'utf8')), 1);

		if(StoreWishlist::model()->countByAttributes(array('key'=>$result))>0)
			$this->createSecretKey($size);

		return $result;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'key' => 'Key',
			'user_id' => 'User',
		);
	}

	/**
	 * @param null $user_id if null will count for current user
	 * @return mixed
	 */
	public static function countByUser($user_id=null)
	{
		if($user_id===null)
			$user_id=Yii::app()->user->id;
		$table=StoreWishlistProducts::model()->tableName();
		return Yii::app()->db->createCommand("SELECT COUNT(id) FROM {$table} WHERE user_id=:user_id")->bindValue(':user_id', $user_id)->queryScalar();
	}

}
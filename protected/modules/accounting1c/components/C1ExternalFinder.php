<?php

/**
 * Find objects by external id
 */
class C1ExternalFinder
{

	const OBJECT_TYPE_CATEGORY=1;
	const OBJECT_TYPE_ATTRIBUTE=2;
	const OBJECT_TYPE_PRODUCT=3;

	/**
	 * @static
	 * @param $type
	 * @param $externalId
	 * @param bool $loadModel
	 */
	public static function getObject($type, $externalId, $loadModel=true)
	{
		$query=Yii::app()->db->createCommand()
			->select("*")
			->from('accounting1c')
			->where('object_type=:type AND external_id=:externalId', array(
				':type'=>$type,
				':externalId'=>$externalId
			))
			->limit(1)
			->queryRow();

		if($query===false)
			return false;

		if($loadModel===true && $query['object_id'])
		{
			switch($type)
			{
				case self::OBJECT_TYPE_CATEGORY:
					return StoreCategory::model()->findByPk($query['object_id']);
				break;

				case self::OBJECT_TYPE_ATTRIBUTE:
					return StoreAttribute::model()->findByPk($query['object_id']);
				break;

				case self::OBJECT_TYPE_PRODUCT:
					return StoreProduct::model()->findByPk($query['object_id']);
				break;
			}
		}
		return $query['object_id'];
	}
}

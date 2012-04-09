<?php

/**
 * Class to access payment method translations
 *
 * @property int $id
 * @property int $object_id
 * @property int $language_id
 */
class StorePaymentMethodTranslate extends CActiveRecord
{

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'StorePaymentMethodTranslate';
	}

}
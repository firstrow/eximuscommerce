<?php

Yii::import('application.modules.store.models.StoreAttributeOptionTranslate');

/**
 * Store options for dropdown and multiple select
 * This is the model class for table "StoreAttributeOptions".
 *
 * The followings are the available columns in table 'StoreAttributeOptions':
 * @property integer $id
 * @property integer $attribute_id
 * @property string $value
 * @property integer $position
 */
class StoreAttributeOption extends BaseModel
{

	public $translateModelName = 'StoreAttributeOptionTranslate';

	/**
	 * @var string multilingual attr
	 */
	public $value;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CActiveRecord the static model class
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
		return 'StoreAttributeOption';
	}

	public function relations()
	{
		return array(
			'option_translate' => array(self::HAS_ONE, $this->translateModelName, 'object_id')
		);
	}

	/**
	 * @return array
	 */
	public function behaviors()
	{
		return array(
			'STranslateBehavior'=>array(
				'class'=>'ext.behaviors.STranslateBehavior',
				'relationName'=>'option_translate',
				'translateAttributes'=>array(
					'value',
				),
			)
		);
	}

}
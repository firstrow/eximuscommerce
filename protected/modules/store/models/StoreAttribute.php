<?php

/**
 * This is the model class for table "StoreAttribute".
 *
 * The followings are the available columns in table 'StoreAttribute':
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property integer $type
 * @property integer $position
 */
class StoreAttribute extends BaseModel
{

	const TYPE_TEXT=1;
	const TYPE_TEXTAREA=2;
	const TYPE_DROPDOWN=3;
	const TYPE_SELECT_MANY=4;
	const TYPE_YESNO=5;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StoreAttribute the static model class
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
		return 'StoreAttribute';
	}

	public function defaultScope()
	{
		return array(
			'order'=>'position ASC',
		);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name, title', 'required'),
			array('name', 'unique'),
			array('name', 'match',
				'pattern'=>'/^([a-z0-9_])+$/i',
				'message'=>Yii::t('StoreModule.core', 'Название может содержать только буквы, цифры и подчеркивания.')
			),
			array('type, position', 'numerical', 'integerOnly'=>true),
			array('name, title', 'length', 'max'=>255),
			array('id, name, title, type', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'options'=>array(self::HAS_MANY, 'StoreAttributeOption', 'attribute_id', 'order'=>'options.position ASC'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'       => 'ID',
			'name'     => Yii::t('StoreModule.core', 'Идентификатор'),
			'title'    => Yii::t('StoreModule.core', 'Название'),
			'type'     => Yii::t('StoreModule.core', 'Тип'),
			'position' => Yii::t('StoreModule.core', 'Позиция'),
		);
	}

	/**
	 * Get types as key value list
	 * @static
	 * @return array
	 */
	public static function getTypesList()
	{
		return array(
			self::TYPE_TEXT        =>'Text',
			self::TYPE_TEXTAREA    =>'Textarea',
			self::TYPE_DROPDOWN    =>'Dropdown',
			self::TYPE_SELECT_MANY =>'Multiple Select',
			self::TYPE_YESNO       =>'Yes/No',
		);
	}

	/**
	 * @return string html field based on attribute type
	 */
	public function renderField()
	{
		$name = 'StoreAttribute['.$this->id.']';
		switch ($this->type):
			case self::TYPE_TEXT:
				return CHtml::textField($name);
			break;
			case self::TYPE_TEXTAREA:
				return CHtml::textArea($name);
			break;
			case self::TYPE_DROPDOWN:
				$data = CHtml::listData($this->options, 'id', 'value');
				return CHtml::dropDownList($name, '', $data, array('empty'=>'---'));
			break;
			case self::TYPE_SELECT_MANY:
				$data = CHtml::listData($this->options, 'id', 'value');
				return CHtml::dropDownList($name, '', $data, array('multiple'=>'multiple'));
			break;
			case self::TYPE_YESNO:
				$data = array(
					1=>Yii::t('StoreModule.core', 'Да'),
					2=>Yii::t('StoreModule.core', 'Нет')
				);
				return CHtml::dropDownList($name, 'asd', $data, array('empty'=>'---'));
			break;
		endswitch;
	}

	/**
	 * Get type label
	 * @static
	 * @param $type
	 * @return string
	 */
	public static function getTypeTitle($type)
	{
		$list = self::getTypesList();
		return $list[$type];
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('position',$this->position);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function afterDelete()
	{
		// Delete options
		foreach($this->options as $o)
			$o->delete();

		// Delete relations used in product type.
		StoreTypeAttribute::model()->deleteAllByAttributes(array('attribute_id'=>$this->id));
	}
}
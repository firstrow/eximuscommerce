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
			array('id, name, title, type, position', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
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
}
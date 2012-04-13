<?php

/**
 * This is the model class for table "StoreCurrency".
 *
 * The followings are the available columns in table 'StoreCurrency':
 * @property integer $id
 * @property string $name
 * @property string $iso
 * @property string $symbol
 * @property float $rate
 * @property integer $main
 * @property integer $default
 */
class StoreCurrency extends BaseModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StoreCurrency the static model class
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
		return 'StoreCurrency';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name, iso, symbol, rate', 'required'),
			array('main, default', 'numerical', 'integerOnly'=>true),
			array('rate', 'numerical'),
			array('name', 'length', 'max'=>255),
			array('iso, symbol', 'length', 'max'=>10),

			array('id, name, iso, symbol, rate, main, default', 'safe', 'on'=>'search'),
		);
	}

	public function afterSave()
	{
		if($this->default)
			StoreCurrency::model()->updateAll(array('default'=>0), 'id != :id', array(':id'=>$this->id));

		if($this->main)
			StoreCurrency::model()->updateAll(array('main'=>0), 'id != :id', array(':id'=>$this->id));

		return parent::afterSave();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'      => 'ID',
			'name'    => Yii::t('StoreModule', 'Название'),
			'iso'     => Yii::t('StoreModule', 'ISO код'),
			'symbol'  => Yii::t('StoreModule', 'Символ'),
			'rate'    => Yii::t('StoreModule', 'Курс'),
			'main'    => Yii::t('StoreModule', 'Главная'),
			'default' => Yii::t('StoreModule', 'По умолчанию'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('t.iso',$this->iso,true);
		$criteria->compare('t.symbol',$this->symbol,true);
		$criteria->compare('t.rate',$this->rate);
		$criteria->compare('t.main',$this->main);
		$criteria->compare('t.default',$this->default);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
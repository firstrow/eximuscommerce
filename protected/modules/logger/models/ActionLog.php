<?php

/**
 * Saves admin logs
 * This is the model class for table "ActionLog".
 *
 * The followings are the available columns in table 'ActionLog':
 * @property integer $id
 * @property string $username
 * @property string $event
 * @property string $model_name
 * @property string $model_title
 * @property string $datetime
 */
class ActionLog extends BaseModel
{

	/**
	 * Actions
	 */
	const ACTION_CREATE = 1;
	const ACTION_UPDATE = 2;
	const ACTION_DELETE = 3;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ActionLog the static model class
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
		return 'ActionLog';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
//			array('username, event, model_name, model_title, datetime', 'required'),
//			array('username, event', 'length', 'max'=>255),
//			array('model_name', 'length', 'max'=>50),
			array('id, username, event, model_name, model_title, datetime', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => Yii::t('LoggerModule.admin', 'Пользователь'),
			'event' => Yii::t('LoggerModule.admin', 'Действие'),
			'model_name' => Yii::t('LoggerModule.admin', 'Обьект'),
			'model_title' => Yii::t('LoggerModule.admin', 'Название'),
			'datetime' => Yii::t('LoggerModule.admin', 'Дата'),
		);
	}

	public function getActionTitle()
	{
		if($this->event)
		{
			return $this->eventNames[$this->event];
		}
	}

	public function getEventNames()
	{
		return array(
			self::ACTION_CREATE=>Yii::t('LoggerModule.admin', 'Создание'),
			self::ACTION_UPDATE=>Yii::t('LoggerModule.admin', 'Обновление'),
			self::ACTION_DELETE=>Yii::t('LoggerModule.admin', 'Удаление'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('event',$this->event,true);
		$criteria->compare('model_name',$this->model_name,true);
		$criteria->compare('model_title',$this->model_title,true);
		$criteria->compare('datetime',$this->datetime,true);

		$sort = new CSort;
		$sort->defaultOrder = 't.datetime DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort
		));
	}
}
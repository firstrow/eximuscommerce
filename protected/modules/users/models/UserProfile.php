<?php

Yii::import('application.modules.users.models.User');

/**
 * This is the model class for table "user_profile".
 *
 * The followings are the available columns in table 'user_profile':
 * @property integer $id
 * @property integer $user_id
 * @property string $full_name
 * @property string $phone
 * @property string $delivery_address
 */
class UserProfile extends BaseModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserProfile the static model class
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
		return 'user_profile';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('full_name', 'required'),
			array('full_name, delivery_address', 'length', 'max'=>255),
			array('phone', 'length', 'max'=>20),
			// Search
			array('id, user_id, full_name, phone, delivery_address', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'user'=>array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id'          => Yii::t('UsersModule.core', 'Пользователь'),
			'full_name'        => Yii::t('UsersModule.core', 'Полное Имя'),
			'phone'            => Yii::t('UsersModule.core', 'Номер телефона'),
			'delivery_address' => Yii::t('UsersModule.core', 'Адрес доставки'),
		);
	}

	/**
	 * Connect profile to user
	 * @param UserProfile $user
	 */
	public function setUser(User $user)
	{
		$this->user_id = $user->id;
		$this->save(false);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('full_name',$this->full_name,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('delivery_address',$this->delivery_address,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
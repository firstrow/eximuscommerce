<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property integer $created_at
 * @property integer $last_login
 * @property string $login_ip
 */
class User extends CActiveRecord 
{
	
	public $new_password;

	/**
	 * Returns the static model of the specified AR class.
	 * @return User the static model class
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
			return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('username, email, created_at, last_login', 'required'),
			array('created_at, last_login', 'date','format'=>'yyyy-M-d H:m:s'),
			array('username, password, email, login_ip', 'length', 'max'=>255),
			array('email', 'email'),
			array('new_password', 'length', 'min'=>4, 'max'=>40),
			array('password', 'length', 'min'=>4, 'max'=>40),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, email, created_at, last_login', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'           => Yii::t('UsersModule.models', 'ID'),
			'username'     => Yii::t('UsersModule.models', 'Логин'),
			'password'     => Yii::t('UsersModule.models', 'Пароль'),
			'email'        => Yii::t('UsersModule.models', 'Email'),
			'created_at'   => Yii::t('UsersModule.models', 'Дата создания'),
			'last_login'   => Yii::t('UsersModule.models', 'Последний вход'),
			'login_ip'     => Yii::t('UsersModule.models', 'IP Адрес'),
			'new_password' => Yii::t('UsersModule.models', 'Новый пароль'),
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
		$criteria->compare('email',$this->email,true);
		$criteria->compare('created_at',$this->created_at, true);
		$criteria->compare('last_login',$this->last_login);

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
	/**
	 *  Encodes user password
	 * 
	 * @param string $string
	 * @return string 
	 */
	public static function encodePassword($string)
	{
		return sha1($string);
	}
	
	public function beforeSave() 
	{
		// Set new password
		if ($this->new_password)
			$this->password = User::encodePassword($this->new_password);        
		return parent::beforeSave();
	}
	
	/**
	 * Generate admin link to edit user. 
	 * @return type
	 */
	public function getUpdateLink()
	{
		// return CHtml::link($this->username,'/admin/users/default/update?id='.$this->id);
		return CHtml::link($this->username, array('/users/admin/default/update', 'id'=>$this->id));
	}
}

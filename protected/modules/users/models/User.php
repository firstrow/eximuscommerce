<?php

Yii::import('application.modules.users.models.UserProfile');

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
 * @property string $recovery_key // Password recovery key
 * @property string $recovery_password
 * @property string $discount
 * @property boolean $banned
 * @property UserProfile $profile
 */
class User extends BaseModel
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
			array('username, email', 'required'),
			array('username, email', 'checkIfAvailable'),
			array('banned', 'boolean'),
			array('password', 'required', 'on'=>'register'),
			array('email', 'email'),
			array('created_at', 'required', 'on'=>'update'),
			array('created_at, last_login', 'date','format'=>array('yyyy-M-d H:m:s', '0000-00-00 00:00:00')),
			array('username, password, email, discount', 'length', 'max'=>255),
			array('new_password', 'length', 'min'=>4, 'max'=>40, 'on'=>'update'),
			array('password', 'length', 'min'=>4, 'max'=>40),
			// Search
			array('id, username, email, created_at, last_login, banned', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Check if username/email is available
	 */
	public function checkIfAvailable($attr)
	{
		$labels = $this->attributeLabels();
		$check = User::model()->countByAttributes(array(
			$attr=>$this->$attr,
		), 't.id != :id', array(':id'=>(int)$this->id));

		if($check>0)
			$this->addError($attr, Yii::t('UsersModule.core', '{attr} уже занят другим пользователем.', array('{attr}'=>$labels[$attr])));
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'profile'=>array(self::HAS_ONE, 'UserProfile', 'user_id'),
			'orders' =>array(self::HAS_MANY, 'Order', 'user_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'           => Yii::t('UsersModule.core', 'ID'),
			'username'     => Yii::t('UsersModule.core', 'Логин'),
			'password'     => Yii::t('UsersModule.core', 'Пароль'),
			'email'        => Yii::t('UsersModule.core', 'Email'),
			'created_at'   => Yii::t('UsersModule.core', 'Дата создания'),
			'last_login'   => Yii::t('UsersModule.core', 'Последний вход'),
			'login_ip'     => Yii::t('UsersModule.core', 'IP Адрес'),
			'new_password' => Yii::t('UsersModule.core', 'Новый пароль'),
			'discount'     => Yii::t('UsersModule.core', 'Персональная скидка'),
			'banned'       => Yii::t('UsersModule.core', 'Бан'),
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
		$criteria->compare('banned',$this->banned);

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

	/**
	 * @return bool
	 */
	public function beforeSave()
	{
		// Set new password
		if ($this->new_password)
			$this->password = User::encodePassword($this->new_password);
		if($this->isNewRecord)
		{
			if(!$this->created_at)
				$this->created_at = date('Y-m-d H:i:s');
			$this->login_ip = Yii::app()->request->userHostAddress;

			if(!$this->hasErrors())
				$this->password=$this->encodePassword($this->password);
		}
		return parent::beforeSave();
	}

	/**
	 * After delete event
	 */
	public function afterDelete()
	{
		$profile = $this->profile;
		if($profile)
			$profile->delete();
		parent::afterDelete();
	}

	/**
	 * Generate admin link to edit user.
	 * @return string
	 */
	public function getUpdateLink()
	{
		return CHtml::link(CHtml::encode($this->username), array('/users/admin/default/update', 'id'=>$this->id));
	}

	/**
	 * Activate new user password
	 * @static
	 * @param $key
	 * @return bool
	 */
	public static function activeNewPassword($key)
	{
		$user = User::model()->findByAttributes(array('recovery_key'=>$key));

		if(!$user)
			return false;

		$user->password=self::encodePassword($user->recovery_password);
		$user->recovery_key='';
		$user->recovery_password='';
		$user->save(false);
		return true;
	}
}

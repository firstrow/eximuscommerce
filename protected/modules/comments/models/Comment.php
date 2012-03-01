<?php

/**
 * This is the model class for table "Comments".
 *
 * The followings are the available columns in table 'Comments':
 * @property integer $id
 * @property integer $user_id
 * @property string $class_name
 * @property integer $object_pk
 * @property integer $status
 * @property string $email
 * @property string $name
 * @property string $text
 * @property string $created
 * @property string $updated
 * @method approved()
 * @method orderByCreatedAsc()
 * @method orderByCreatedDesc()
 */
class Comment extends BaseModel
{

	const STATUS_WAITING = 0;
	const STATUS_APPROVED = 1;
	const STATUS_SPAM = 2;

	public $verifyCode;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Comment the static model class
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
		return 'Comments';
	}

	public function scopes()
	{
		$alias = $this->getTableAlias();
		return array(
			'orderByCreatedAsc'=>array(
				'order'=>$alias.'.created ASC',
			),
			'orderByCreatedDesc'=>array(
				'order'=>$alias.'.created DESC',
			),
			'waiting'=>array(
				'condition'=>$alias.'.status='.self::STATUS_WAITING,
			),
			'approved'=>array(
				'condition'=>$alias.'.status='.self::STATUS_APPROVED,
			),
			'spam'=>array(
				'condition'=>$alias.'.status='.self::STATUS_SPAM,
			)
		);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('email, name, text', 'required'),
			array('email', 'email'),
			array('name', 'length', 'max'=>50),
			array('verifyCode','captcha','allowEmpty'=>!Yii::app()->user->isGuest),
			// Search
			array('id, user_id, class_name, status, email, name, text, created, updated', 'safe', 'on'=>'search'),
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
			'id'         => 'ID',
			'user_id'    => Yii::t('CommentsModule.core','Автор'),
			'class_name' => Yii::t('CommentsModule.core','Модель'),
			'status'     => Yii::t('CommentsModule.core','Статус'),
			'email'      => Yii::t('CommentsModule.core','Почта'),
			'name'       => Yii::t('CommentsModule.core','Имя'),
			'text'       => Yii::t('CommentsModule.core','Комментарий'),
			'created'    => Yii::t('CommentsModule.core','Дата создания'),
			'updated'    => Yii::t('CommentsModule.core','Дата обновления'),
			'verifyCode' => Yii::t('CommentsModule.core','Код проверки'),
		);
	}

	/**
	 * Before save!
	 */
	public function beforeSave()
	{
		if($this->isNewRecord)
			$this->created = date('Y-m-d H:i:s');
		$this->updated = date('Y-m-d H:i:s');
		return parent::beforeSave();
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
		$criteria->compare('class_name',$this->class_name,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Load object comments
	 * @static
	 * @param CActiveRecord $model
	 * @return array
	 */
	public static function getObjectComments(CActiveRecord $model)
	{
		return Comment::model()
			->approved()
			->orderByCreatedAsc()
			->findAllByAttributes(array(
				'class_name'=>get_class($model),
				'object_pk'=>$model->id
		));
	}
}
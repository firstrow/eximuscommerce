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
 */
class Comment extends BaseModel
{
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
			'orderByCreated'=>array(
				'order'=>$alias.'.created DESC',
			),
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
			'user_id'    => 'Автор',
			'class_name' => 'Class Name',
			'status'     => 'Статус',
			'email'      => 'Email',
			'name'       => 'Имя',
			'text'       => 'Комментарий',
			'created'    => 'Дата создания',
			'updated'    => 'Дата обновления',
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
}
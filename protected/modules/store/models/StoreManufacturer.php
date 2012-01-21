
<?php

/**
 * This is the model class for table "StoreManufacturer".
 *
 * The followings are the available columns in table 'StoreManufacturer':
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property string $description
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $layout
 * @property string $view
 */
class StoreManufacturer extends BaseModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StoreManufacturer the static model class
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
		return 'StoreManufacturer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('url', 'LocalUrlValidator'),
			array('name, url, description, meta_title, meta_keywords, meta_description, layout, view', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, url, description, meta_title, meta_keywords, meta_description, layout, view', 'safe', 'on'=>'search'),
		);
	}

	public function defaultScope()
	{
		return array(
			'order'=>'name ASC',
		);
	}

	/**
	 * Find manufacturer by url.
	 * Scope.
	 * @param string Product url
	 * @return StoreProduct
	 */
	public function withUrl($url)
	{
		$this->getDbCriteria()->mergeWith(array(
			'condition'=>'url=:url',
			'params'=>array(':url'=>$url)
		));
		return $this;
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
			'id'               => 'ID',
			'name'             => Yii::t('StoreModule.admin','Название'),
			'url'              => Yii::t('StoreModule.admin','URL'),
			'description'      => Yii::t('StoreModule.admin','Описание'),
			'meta_title'       => Yii::t('StoreModule.admin','Meta Title'),
			'meta_keywords'    => Yii::t('StoreModule.admin','Meta Keywords'),
			'meta_description' => Yii::t('StoreModule.admin','Meta Description'),
			'layout'           => Yii::t('StoreModule.admin','Макет'),
			'view'             => Yii::t('StoreModule.admin','Шаблон'),
		);
	}

	public function beforeSave()
	{
		if (empty($this->url))
		{
			// Create slug
			Yii::import('ext.SlugHelper.SlugHelper');
			$this->url = SlugHelper::run($this->name);
		}

		// Check if url available
		if($this->isNewRecord)
		{
			$test = StoreManufacturer::model()
				->withUrl($this->url)
				->count();
		}
		else
		{
			$test = StoreManufacturer::model()
				->withUrl($this->url)
				->count('id!=:id', array(':id'=>$this->id));
		}

		// Create unique url
		if ($test > 0)
			$this->url .= '-'.date('YmdHis');

		return parent::beforeSave();
	}

	public function afterDelete()
	{
		// Clear product relations
		StoreProduct::model()->updateAll(array(
			'manufacturer_id'=>0,
		), 'manufacturer_id = :id', array(':id'=>$this->id));
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
		$criteria->compare('url',$this->url,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('layout',$this->layout,true);
		$criteria->compare('view',$this->view,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
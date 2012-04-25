<?php

Yii::import('application.modules.store.models.StoreManufacturerTranslate');

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
 * @method StoreManufacturer orderByName()
 */
class StoreManufacturer extends BaseModel
{

	public $translateModelName = 'StoreManufacturerTranslate';

	/**
	 * Multilingual attrs
	 */
	public $name;
	public $description;
	public $meta_title;
	public $meta_description;
	public $meta_keywords;

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
		return array(
			array('name', 'required'),
			array('url', 'LocalUrlValidator'),
			array('name, url, description, meta_title, meta_keywords, meta_description, layout, view', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, url, description, meta_title, meta_keywords, meta_description, layout, view', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Find manufacturer by url.
	 * Scope.
	 * @param string $url
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
			'man_translate'=>array(self::HAS_ONE, $this->translateModelName, 'object_id'),
			'productsCount'=>array(self::STAT, 'StoreProduct', 'manufacturer_id', 'select'=>'count(t.id)'),
		);
	}

	public function scopes()
	{
		return array(
			'orderByName'=>array(
				'order'=> 'man_translate.name'
			),
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

	/**
	 * @return array
	 */
	public function behaviors()
	{
		return array(
			'STranslateBehavior'=>array(
				'class'=>'ext.behaviors.STranslateBehavior',
				'relationName'=>'man_translate',
				'translateAttributes'=>array(
					'name',
					'description',
					'meta_title',
					'meta_description',
					'meta_keywords',
				),
			),
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
			'manufacturer_id' => new CDbExpression('NULL'),
		), 'manufacturer_id = :id', array(':id'=>$this->id));

		return parent::afterDelete();
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->with = array('man_translate');

		$criteria->compare('t.id',$this->id);
		$criteria->compare('man_translate.name',$this->name,true);
		$criteria->compare('t.url',$this->url,true);
		$criteria->compare('man_translate.description',$this->description,true);
		$criteria->compare('t.layout',$this->layout,true);
		$criteria->compare('t.view',$this->view,true);

		$sort = new CSort;
		$sort->attributes=array(
			'*',
			'name' => array(
				'asc'   => 'man_translate.name',
				'desc'  => 'man_translate.name DESC',
			),
		);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}
}
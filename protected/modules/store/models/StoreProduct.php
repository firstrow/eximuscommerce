<?php

/**
 * This is the model class for table "StoreProduct".
 *
 * The followings are the available columns in table 'StoreProduct':
 * @property integer $id
 * @property integer $manufacturer_id
 * @property integer $type_id
 * @property string $name
 * @property string $url
 * @property double $price
 * @property boolean $is_active
 * @property string $short_description
 * @property string $full_description
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $layout
 * @property string $view
 * @property string $sku
 * @property string $quantity
 * @property string $auto_decrease_quantity
 * @property string $availability
 * @property string $created
 * @property string $updated
 */
class StoreProduct extends BaseModel
{

	/**
	 * @var null Id if product to exclude from search
	 */
	public $exclude = null;

	/**
	 * @var array of related products
	 */
	private $_related;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className
	 * @return StoreProduct the static model class
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
		return 'StoreProduct';
	}

	public function scopes()
	{
		return array(
			'active'=>array(
				'condition'=>'is_active=1',
			),
		);
	}

	/**
	 * Find product by url.
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
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('price', 'commaToDot'),
			array('price, type_id', 'numerical'),
			array('is_active', 'boolean'),
			array('quantity, availability, manufacturer_id', 'numerical', 'integerOnly'=>true),
			array('name, price', 'required'),
			array('url', 'LocalUrlValidator'),
			array('name, url, meta_title, meta_keywords, meta_description, layout, view, sku', 'length', 'max'=>255),
			array('short_description, full_description, auto_decrease_quantity', 'type'),
			// Search
			array('id, name, url, price, short_description, full_description, created, updated', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Replaces comma to dot
	 * @param $attr
	 */
	public function commaToDot($attr)
	{
		$this->$attr = str_replace(',','.', $this->$attr);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'images'=>array(self::HAS_MANY, 'StoreProductImage', 'product_id'),
			'manufacturer'=>array(self::BELONGS_TO, 'StoreManufacturer', 'manufacturer_id'),
			'type'=>array(self::BELONGS_TO, 'StoreProductType', 'type_id'),
			'related'=>array(self::HAS_MANY, 'StoreRelatedProduct', 'product_id'),
			'relatedProducts'=>array(self::HAS_MANY, 'StoreProduct', array('related_id'=>'id'), 'through'=>'related'),
			'categorization'=>array(self::HAS_MANY, 'StoreProductCategoryRef', 'product'),
			'categories'=>array(self::HAS_MANY, 'StoreCategory',array('category'=>'id'), 'through'=>'categorization'),
			'mainCategory'=>array(self::HAS_ONE, 'StoreCategory', array('category'=>'id'), 'through'=>'categorization', 'condition'=>'categorization.is_main = 1')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'                     => 'ID',
			'manufacturer_id'        => Yii::t('StoreModule.core', 'Производитель'),
			'type_id'                => Yii::t('StoreModule.core', 'Тип'),
			'name'                   => Yii::t('StoreModule.core', 'Название'),
			'url'                    => Yii::t('StoreModule.core', 'URL'),
			'price'                  => Yii::t('StoreModule.core', 'Цена'),
			'is_active'              => Yii::t('StoreModule.core', 'Активен'),
			'short_description'      => Yii::t('StoreModule.core', 'Краткое описание'),
			'full_description'       => Yii::t('StoreModule.core', 'Полное описание'),
			'meta_title'             => Yii::t('StoreModule.core', 'Meta Title'),
			'meta_keywords'          => Yii::t('StoreModule.core', 'Meta Keywords'),
			'meta_description'       => Yii::t('StoreModule.core', 'Meta Description'),
			'layout'                 => Yii::t('StoreModule.core', 'Макет'),
			'view'                   => Yii::t('StoreModule.core', 'Шаблон'),
			'sku'                    => Yii::t('StoreModule.core', 'Артикул'),
			'quantity'               => Yii::t('StoreModule.core', 'Количество'),
			'availability'           => Yii::t('StoreModule.core', 'Доступность'),
			'auto_decrease_quantity' => Yii::t('StoreModule.core', 'Автоматически уменьшать количество'),
			'created'                => Yii::t('StoreModule.core', 'Дата создания'),
			'updated'                => Yii::t('StoreModule.core', 'Дата обновления'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($params = array())
	{
		$criteria=new CDbCriteria;

		$criteria->with = array(
			'categorization'=>array('together'=>true),
		);

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('t.url',$this->url,true);
		$criteria->compare('t.price',$this->price);
		$criteria->compare('t.is_active',$this->is_active);
		$criteria->compare('t.short_description',$this->short_description,true);
		$criteria->compare('t.full_description',$this->full_description,true);
		$criteria->compare('t.sku',$this->sku,true);
		$criteria->compare('t.created',$this->created,true);
		$criteria->compare('t.updated',$this->updated,true);
		$criteria->compare('type_id', $this->type_id);

		if (isset($params['category']) && $params['category'])
			$criteria->compare('categorization.category', $params['category']);

		// Id of product to exclude from search
		if($this->exclude)
			$criteria->compare('t.id !', array(':id'=>$this->exclude));

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'t.created DESC'
			),
			'pagination'=>array(
				'pageSize'=>20,
			)
		));
	}

	public function behaviors()
	{
		return array(
			'eavAttr' => array(
				'class' => 'ext.behaviors.eav.EEavBehavior',
				'tableName' => 'StoreProductAttributeEAV',
			)
		);
	}

	/**
	 * Save related products. Notice, related product will be saved after save() method called.
	 * @param array $ids Array of related products
	 */
	public function setRelatedProducts($ids = array())
	{
		$this->_related = $ids;
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
			$test = StoreProduct::model()
				->withUrl($this->url)
				->count();
		}
		else
		{
			$test = StoreProduct::model()
				->withUrl($this->url)
				->count('id!=:id', array(':id'=>$this->id));
		}

		// Create unique url
		if ($test > 0)
			$this->url .= '-'.date('YmdHis');

		return parent::beforeSave();
	}

	public function afterSave()
	{
		// Process related products
		if($this->_related !== null)
		{
			$this->clearRelatedProducts();

			foreach($this->_related as $id)
			{
				$related = new StoreRelatedProduct;
				$related->product_id = $this->id;
				$related->related_id = $id;
				$related->save();
			}
		}

		return parent::afterSave();
	}

	public function afterDelete()
	{
		// Delete related products
		$this->clearRelatedProducts();
		StoreRelatedProduct::model()->deleteAll('related_id=:id', array('id'=>$this->id));

		// Delete categorization
		StoreProductCategoryRef::model()->deleteAllByAttributes(array(
			'product'=>$this->id
		));

		// Delete images
		$images = $this->images;
		if(!empty($images))
		{
			foreach ($images as $image)
				$image->delete();
		}

		return parent::afterDelete();
	}

	/**
	 * Clear all related products
	 */
	private function clearRelatedProducts()
	{
		StoreRelatedProduct::model()->deleteAll('product_id=:id', array('id'=>$this->id));
	}

	/**
	 * @return array
	 */
	public function getAvailabilityItems()
	{
		return array(
			1=>Yii::t('StoreModule.core', 'Есть на складе'),
			2=>Yii::t('StoreModule.core', 'Нет на складе'),
		);
	}

	/**
	 * @param array $categories
	 */
	public function setCategories(array $categories, $main_category)
	{
		$dontDelete = array();

		if(!StoreCategory::model()->countByAttributes(array('id'=>$main_category)))
			$main_category = 1;

		if(!in_array($main_category, $categories))
			array_push($categories, $main_category);

		foreach ($categories as $c)
		{
			$count = StoreProductCategoryRef::model()->countByAttributes(array(
				'category'=>$c,
				'product'=>$this->id
			));

			if($count == 0)
			{
				$record = new StoreProductCategoryRef;
				$record->category = (int)$c;
				$record->product = $this->id;
				$record->save(false);
			}

			$dontDelete[] = $c;
		}

		// Clear main category
		StoreProductCategoryRef::model()->updateAll(array(
			'is_main'=>0
		), 'product=:p', array(':p'=>$this->id));

		// Set main category
		StoreProductCategoryRef::model()->updateAll(array(
			'is_main'=>1
		), 'product=:p AND category=:c ', array(':p'=>$this->id,':c'=>$main_category));

		// Delete not used relations
		if(sizeof($dontDelete) > 0)
		{
			$cr = new CDbCriteria;
			$cr->addNotInCondition('category', $dontDelete);

			StoreProductCategoryRef::model()->deleteAllByAttributes(array(
				'product'=>$this->id,
			), $cr);
		}
		else
		{
			// Delete all relations
			StoreProductCategoryRef::model()->deleteAllByAttributes(array(
				'product'=>$this->id,
			));
		}
	}
}
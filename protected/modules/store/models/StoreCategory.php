<?php

Yii::import('application.modules.store.StoreModule');
Yii::import('application.modules.store.models.StoreCategoryTranslate');

/**
 * This is the model class for table "StoreCategory".
 *
 * The followings are the available columns in table 'StoreCategory':
 * @property string $id
 * @property string $lft
 * @property string $rgt
 * @property integer $level
 * @property string $name
 * @property string $url
 * @property string $full_path
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $layout
 * @property string $description
 * @property string $view
 */
class StoreCategory extends BaseModel
{

	/**
	 * @var int Parent category id
	 */
	public $parent_id;

	public $translateModelName = 'StoreCategoryTranslate';

	/**
	 * Multilingual attrs
	 */
	public $name;
	public $meta_title;
	public $meta_description;
	public $meta_keywords;
	public $description;

	/**
	 * Returns the static model of the specified AR class.
	 * @return StoreCategory the static model class
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
		return 'StoreCategory';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name', 'required'),
			array('url', 'LocalUrlValidator'),
			array('name, url, meta_keywords, meta_title, meta_description, layout, view', 'length', 'max'=>255),
			array('description', 'type', 'type'=>'string'),
			// Search
			array('id, name, url', 'safe', 'on'=>'search'),
		);
	}

	public function behaviors()
	{
		return array(
			'NestedSetBehavior'=>array(
				'class'=>'ext.behaviors.NestedSet.NestedSetBehavior',
				'leftAttribute'=>'lft',
				'rightAttribute'=>'rgt',
				'levelAttribute'=>'level'
			),
			'SAsCMenuArrayBehavior'=>array(
				'class'=>'ext.behaviors.SAsCMenuArrayBehavior',
				'labelAttr'=>'name',
				'urlExpression'=>'array("/store/category/view", "url"=>$model->url)',
			),
			'STranslateBehavior'=>array(
				'class'=>'ext.behaviors.STranslateBehavior',
				'relationName'=>'cat_translate',
				'translateAttributes'=>array(
					'name',
					'meta_title',
					'meta_description',
					'meta_keywords',
					'description',
				),
			),
		);
	}

	/**
	 * Find category by url.
	 * Scope.
	 * @param string $url
	 * @return StoreProduct
	 */
	public function withUrl($url, $alias = 't')
	{
		$this->getDbCriteria()->mergeWith(array(
			'condition' => $alias.'.url=:url',
			'params'    => array(':url'=>$url)
		));
		return $this;
	}

	/**
	 * @return StoreCategory
	 */
	public function excludeRoot($alias = 't')
	{
		$this->getDbCriteria()->mergeWith(array(
			'condition'=>$alias.'.id != 1',
		));
		return $this;
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'countProducts' => array(self::STAT, 'StoreProductCategoryRef', 'category'),
			'cat_translate' => array(self::HAS_ONE, $this->translateModelName, 'object_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'               => 'ID',
			'lft'              => 'Lft',
			'rgt'              => 'Rgt',
			'level'            => Yii::t('StoreModule.core', 'Уровень'),
			'name'             => Yii::t('StoreModule.core', 'Название'),
			'url'              => Yii::t('StoreModule.core', 'URL'),
			'full_path'        => Yii::t('StoreModule.core', 'Полный путь'),
			'meta_title'       => Yii::t('StoreModule.core', 'Meta Title'),
			'meta_keywords'    => Yii::t('StoreModule.core', 'Meta Keywords'),
			'meta_description' => Yii::t('StoreModule.core', 'Meta Description'),
			'layout'           => Yii::t('StoreModule.core', 'Макет'),
			'view'             => Yii::t('StoreModule.core', 'Шаблон'),
			'description'      => Yii::t('StoreModule.core', 'Описание')
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
			$test = StoreCategory::model()
				->withUrl($this->url)
				->count();
		}
		else
		{
			$test = StoreCategory::model()
				->withUrl($this->url)
				->count('id!=:id', array(':id'=>$this->id));
		}

		// Create unique url
		if ($test > 0)
			$this->url .= '-'.date('YmdHis');

		// Create category full path.
		$ancestors = $this->ancestors()->findAll();
		if(sizeof($ancestors))
		{
			// Remove root category from path
			unset($ancestors[0]);

			$path = array();
			foreach($ancestors as $ancestor)
				array_push($path, $ancestor->url);
			array_push($path, $this->url);
			$this->full_path = implode('/', array_filter($path));
		}

		return parent::beforeSave();
	}

	public function afterDelete()
	{
		// Remove all category-product relations
		StoreProductCategoryRef::model()->deleteAllByAttributes(array(
			'category'=>$this->id,
			'is_main'=>'0'
		));
		return parent::afterDelete();
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->with = array('cat_translate');

		$criteria->compare('id',$this->id,true);
		$criteria->compare('level',$this->level);
		$criteria->compare('cat_translate.name',$this->name,true);
		$criteria->compare('url',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getViewUrl()
	{
		return Yii::app()->createUrl('/store/category/view', array('url'=>$this->url));
	}

}
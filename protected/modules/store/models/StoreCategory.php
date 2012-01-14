<?php

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
 */
class StoreCategory extends BaseModel
{

	/**
	 * @var int Parent category id
	 */
	public $parent_id;

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
			array('name, url, meta_keywords, meta_title, meta_description, layout, view', 'length', 'max'=>255),

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
				'urlExpression'=>'array("/store/category", "id"=>$model->id)',
			),
		);
	}

	/**
	 * Find category by url.
	 * Scope.
	 * @param string Category url
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
			'id' => 'ID',
			'level' => 'Level',
			'name' => 'Name',
			'url' => 'Url',
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

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('level',$this->level);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('url',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
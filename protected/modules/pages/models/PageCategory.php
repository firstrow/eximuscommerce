<?php

/**
 * This is the model class for table "PageCategory".
 *
 * The followings are the available columns in table 'PageCategory':
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 * @property string $url
 * @property string $description
 * @property string $layout
 * @property string $view
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $created
 * @property string $updated
 */
class PageCategory extends BaseModel
{

    public $level = 0;
    public $_nameWithLevel;

    /**
     * Returns the static model of the specified AR class.
     * @return PageCategory the static model class
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
        return 'PageCategory';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array(' description, layout, view', 'type'),
            array('name, url', 'required'),
            array('url', 'LocalUrlValidator'),
            array('parent_id', 'numerical', 'integerOnly'=>true),
            array('name, url, layout, view, meta_title, meta_description, meta_keywords', 'length', 'max'=>255),
            // The following rule is used by search().
            array('id, parent_id, name, url, description, layout, view, meta_title, meta_description, meta_keywords, created, updated', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'pages'=>array(self::HAS_MANY, 'Page', 'category_id'),
            'pageCount'=>array(self::STAT, 'Page', 'category_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'parent_id' => 'Родитель',
            'name' => 'Название',
            'url' => 'URL',
            'description' => 'Описание',
            'layout' => 'Макет',
            'view' => 'Шаблон',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'created' => 'Дата создания',
            'updated' => 'Дата обновления',
            'pages' => 'Страницы',
        );
    }

    /**
     * Get all categories list to display in dropdown.
     * @param type $excludeId Exclude self model 
     * @return array id=>name
     */
    public static function keyValueList()
    {
        $models = PageCategory::model()->findAll();
        $tree = new PageCategoryTree($models);
        return CHtml::listData($tree->buildTree(), 'id', 'nameWithLevel');
    }

    /**
     * Get category name to display in dropdown list.
     * @return string "-- CategoryName"
     */
    public function getNameWithLevel()
    {
        return str_repeat('-', $this->level).' '.$this->name;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('parent_id',$this->parent_id);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('url',$this->url,true);
        $criteria->compare('description',$this->description,true);
        $criteria->compare('layout',$this->layout,true);
        $criteria->compare('view',$this->view,true);
        $criteria->compare('meta_title',$this->meta_title,true);
        $criteria->compare('meta_description',$this->meta_description,true);
        $criteria->compare('meta_keywords',$this->meta_keywords,true);
        $criteria->compare('created',$this->created,true);
        $criteria->compare('updated',$this->updated,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Generate admin link to edit category. 
     * @return type
     */
    public function getUpdateLink()
    {
        return CHtml::link($this->name, array('/pages/admin/category/update', 'id'=>$this->id));
    }

    public function __toString()
    {
        return $this->name;
    }
}
<?php

Yii::import('application.modules.pages.models.PageCategoryTranslate');

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
 * @property integer $page_size
 * @property string $created
 * @property string $updated
 */
class PageCategory extends BaseModel
{

    /**
     * Default page size.
     */
    public $defaultPageSize = 10;

    /**
     * Set level on PageCategoryTree::buildTree()
     */
    public $level;

    /**
     * Set temp path on PageCategoryTree::buildTree()
     */
    public $path;

    /**
     * @var string name prefixed with "-"
     */
    public $_nameWithLevel;

    /**
     * Translate-able
     */
    public $name;
    public $description;
    public $meta_title;
    public $meta_description;
    public $meta_keywords;

    public $translateModelName = 'PageCategoryTranslate';

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
            array('description, layout, view', 'type'),
            array('name', 'required'),
            array('url', 'LocalUrlValidator'),
            array('parent_id, page_size', 'numerical', 'integerOnly'=>true),
            array('name, url, layout, view, meta_title, meta_description, meta_keywords', 'length', 'max'=>255),
            // The following rule is used by search().
            array('id, parent_id, name, url, description, layout, view, meta_title, meta_description, meta_keywords, created, updated', 'safe', 'on'=>'search'),
        );
    }

    /**
     * Find category by url.
     * Scope.
     * @return Page
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
     * Find category by full_url.
     * Scope.
     * @return Page
     */
    public function withFullUrl($url)
    {
        $this->getDbCriteria()->mergeWith(array(
            'condition'=>'full_url=:url',
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
            'translate'=>array(self::HAS_ONE, $this->translateModelName, 'object_id'),
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
            'parent_id' => Yii::t('PagesModule.core', 'Родитель'),
            'name' => Yii::t('PagesModule.core', 'Название'),
            'url' => Yii::t('PagesModule.core', 'URL'),
            'description' => Yii::t('PagesModule.core', 'Описание'),
            'layout' => Yii::t('PagesModule.core', 'Макет'),
            'view' => Yii::t('PagesModule.core', 'Шаблон'),
            'meta_title' => Yii::t('PagesModule.core', 'Meta Title'),
            'meta_description' => Yii::t('PagesModule.core', 'Meta Description'),
            'meta_keywords' => Yii::t('PagesModule.core', 'Meta Keywords'),
            'created' => Yii::t('PagesModule.core', 'Дата создания'),
            'updated' => Yii::t('PagesModule.core', 'Дата обновления'),
            'pages' => Yii::t('PagesModule.core', 'Страницы'),
            'page_size' => Yii::t('PagesModule.core', 'Записей на странице'),
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

        $criteria->with = array('translate');

        $criteria->compare('id',$this->id);
        $criteria->compare('parent_id',$this->parent_id);
        $criteria->compare('translate.name',$this->name,true);
        $criteria->compare('url',$this->url,true);
        $criteria->compare('translate.description',$this->description,true);
        $criteria->compare('layout',$this->layout,true);
        $criteria->compare('view',$this->view,true);
        $criteria->compare('translate.meta_title',$this->meta_title,true);
        $criteria->compare('translate.meta_description',$this->meta_description,true);
        $criteria->compare('translate.meta_keywords',$this->meta_keywords,true);
        $criteria->compare('created',$this->created,true);
        $criteria->compare('updated',$this->updated,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function behaviors()
    {
        return array(
            'STranslateBehavior'=>array(
                'class'=>'ext.behaviors.STranslateBehavior',
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
        if(!$this->created && $this->isNewRecord)
            $this->created = date('Y-m-d H:i:s');
        if(!$this->updated)
            $this->updated = date('Y-m-d H:i:s');

        if (empty($this->url))
        {
            Yii::import('ext.SlugHelper.SlugHelper');
            $this->url = SlugHelper::run($this->name);
        }

        // Check if url available
        if($this->isNewRecord)
        {
            $test = PageCategory::model()
                ->withUrl($this->url)
                ->count('parent_id=:parent_id', array(
                    ':parent_id'=>$this->parent_id
                ));
        }
        else
        {
            $test = PageCategory::model()
                ->withUrl($this->url)
                ->count('id!=:id AND parent_id=:parent_id', array(
                    ':id'=>$this->id,
                    ':parent_id'=>$this->parent_id,
                ));
        }

        if ($test > 0)
            $this->url .= '-'.date('YmdHis');

        return parent::beforeSave();
    }

    /**
     * Delete category pages and childs.
     * @return boolean
     */
    public function beforeDelete()
    {
        // Delete pages
        $pages = $this->pages;
        if ($pages)
        {
            foreach($pages as $p)
                $p->delete();
        }

        // Delete all child categories
        $tree = new PageCategoryTree();
        $tree = $tree->buildTree($this->id);

        if (count($tree) > 0)
        {
            foreach($tree as $child)
                $child->delete();
        }

        return parent::beforeDelete();
    }

    /**
     * Generate admin link to edit category.
     * @return type
     */
    public function getUpdateLink()
    {
        return CHtml::link(CHtml::encode($this->name), array('/pages/admin/category/update', 'id'=>$this->id));
    }

    /**
     * Get url to view object on front
     * @return string
     */
    public function getViewUrl()
    {
        return Yii::app()->createUrl('pages/pages/list', array('url'=>$this->full_url));
    }

    public function __toString()
    {
        return $this->name;
    }
}
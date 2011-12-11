<?php

/**
 * This is the model class for table "StoreProduct".
 *
 * The followings are the available columns in table 'StoreProduct':
 * @property integer $id
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
            array('price', 'numerical'),
            array('is_active', 'boolean'),
            array('quantity, availability', 'numerical', 'integerOnly'=>true),
            array('name, price', 'required'),
            array('url', 'LocalUrlValidator'),
            array('name, url, meta_title, meta_keywords, meta_description, layout, view, sku', 'length', 'max'=>255),
            array('short_description, full_description, auto_decrease_quantity', 'type'),
            // Search
            array('id, name, url, price, short_description, full_description, created, updated', 'safe', 'on'=>'search'),
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
            'id' => 'ID',
            'name' => 'Name',
            'url' => 'Url',
            'price' => 'Price',
            'short_description' => 'Short Description',
            'full_description' => 'Full Description',
            'created' => 'Created',
            'updated' => 'Updated',
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
        $criteria->compare('name',$this->name,true);
        $criteria->compare('url',$this->url,true);
        $criteria->compare('price',$this->price);
        $criteria->compare('short_description',$this->short_description,true);
        $criteria->compare('full_description',$this->full_description,true);
        $criteria->compare('sku',$this->sku,true);
        $criteria->compare('created',$this->created,true);
        $criteria->compare('updated',$this->updated,true);

        // Id of product to exclude from search
        if($this->exclude)
            $criteria->compare('t.id !', array(':id'=>$this->exclude));

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'t.created DESC'
            ),
        ));
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

        if ($test > 0)
            $this->url .= '-'.date('YmdHis');

        return parent::beforeSave();
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
}
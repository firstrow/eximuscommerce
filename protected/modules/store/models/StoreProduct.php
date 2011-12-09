<?php

/**
 * This is the model class for table "StoreProduct".
 *
 * The followings are the available columns in table 'StoreProduct':
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property double $price
 * @property string $short_description
 * @property string $full_description
 * @property string $created
 * @property string $updated
 */
class StoreProduct extends BaseModel
{
    /**
     * Returns the static model of the specified AR class.
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
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('price', 'numerical'),
            array('name, price', 'required'),
            array('url', 'LocalUrlValidator'),
            array('name, url', 'length', 'max'=>255),
            array('short_description, full_description', 'type'),
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
        $criteria->compare('created',$this->created,true);
        $criteria->compare('updated',$this->updated,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}
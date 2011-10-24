<?php

/**
 * This is the model class for table "Pages".
 *
 * The followings are the available columns in table 'Pages':
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $url
 * @property string $short_description
 * @property string $full_description
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $created
 * @property string $updated
 */
class Page extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return Pages the static model class
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
        return 'Page';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('short_description, full_description', 'type'),
            array('title, url', 'required'),
            array('title, url, meta_title, meta_description, meta_keywords', 'length', 'max'=>255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, user_id, title, url, short_description, full_description, meta_title, meta_description, meta_keywords, created, updated', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'author'=>array(self::BELONGS_TO, 'User', 'user_id')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'title' => 'Title',
            'url' => 'Url',
            'short_description' => 'Short Description',
            'full_description' => 'Full Description',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'created' => 'Created',
            'updated' => 'Updated',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions. Used in admin search.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria=new CDbCriteria;

        $criteria->with = array('author');
        $criteria->compare('id',$this->id);
        $criteria->compare('author.username',$this->user_id,true);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('url',$this->url,true);
        $criteria->compare('short_description',$this->short_description,true);
        $criteria->compare('full_description',$this->full_description,true);
        $criteria->compare('meta_title',$this->meta_title,true);
        $criteria->compare('meta_description',$this->meta_description,true);
        $criteria->compare('meta_keywords',$this->meta_keywords,true);
        $criteria->compare('created',$this->created,true);
        $criteria->compare('updated',$this->updated,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function beforeSave()
    {
        if (!Yii::app()->user->isGuest) 
            $this->user_id = Yii::app()->user->id;

        return parent::beforeSave();
    }
}

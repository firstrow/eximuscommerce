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
 * @property string $publish_date
 * @property string $status
 * 
 * TODO: Set DB indexes
 */
class Page extends BaseModel
{

    public $_statusLabel;

    /**
     * Status to allow display page on the front.
     */
    public $publishStatus = 'published';

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

    public function scopes()
    {
        return array(
            'published'=>array(
                'condition'=>'publish_date <= :date AND status = :status',
                'params'=>array(
                    ':date'=>date('Y-m-d H:i:s'),
                    ':status'=>$this->publishStatus,
                ),
            ),
        );
    }

    /**
     * Find page by url.
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
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('short_description, full_description', 'type'),
            array('status', 'in', 'range'=>array_keys(self::statuses())),
            array('title, url, status, publish_date', 'required'),
            array('url', 'LocalUrlValidator'),
            array('publish_date', 'date', 'format'=>'yyyy-MM-dd HH:mm:ss'),
            array('title, url, meta_title, meta_description, meta_keywords, publish_date', 'length', 'max'=>255),
            // The following rule is used by search().
            array('id, user_id, title, url, short_description, full_description, meta_title, meta_description, meta_keywords, created, updated, publish_date', 'safe', 'on'=>'search'),
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
            'user_id' => 'Автор',
            'title' => 'Заглавление',
            'url' => 'URL',
            'short_description' => 'Краткое описание',
            'full_description' => 'Содержание',
            'meta_title' => 'Title',
            'meta_description' => 'Description',
            'meta_keywords' => 'Keywords',
            'created' => 'Дата создания',
            'updated' => 'Дата обновления',
            'publish_date' => 'Дата публикации',
            'status' => 'Статус',
        );
    }

    public function statuses()
    {
        return array(
            'published'=>'Опубликован',
            'waiting'=>'Ждет одобрения',
            'draft'=>'Черновик',
            'archive'=>'Архив',
        );
    }

    public function getStatusLabel()
    {
        $statuses = $this->statuses();
        return $statuses[$this->status];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions. Used in admin search.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria=new CDbCriteria;

        $criteria->with = array('author');
        $criteria->compare('t.id',$this->id);
        $criteria->compare('author.username',$this->user_id,true);
        $criteria->compare('t.title',$this->title,true);
        $criteria->compare('t.url',$this->url,true);
        $criteria->compare('t.short_description',$this->short_description,true);
        $criteria->compare('t.full_description',$this->full_description,true);
        $criteria->compare('t.meta_title',$this->meta_title,true);
        $criteria->compare('t.meta_description',$this->meta_description,true);
        $criteria->compare('t.meta_keywords',$this->meta_keywords,true);
        $criteria->compare('t.created',$this->created,true);
        $criteria->compare('t.updated',$this->updated,true);
        $criteria->compare('t.publish_date',$this->publish_date,true);
        $criteria->compare('t.status',$this->status);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>20,
            )
        ));
    }

    public function beforeSave()
    {
        if (!Yii::app()->user->isGuest) 
            $this->user_id = Yii::app()->user->id;

        return parent::beforeSave();
    }
}

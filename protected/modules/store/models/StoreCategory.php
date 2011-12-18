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
            array('parent_id', 'numerical'),
            array('parent_id', 'checkCategoryExists'),
            array('name', 'length', 'max'=>255),

            array('id, name', 'safe', 'on'=>'search'),
        );
    }

    public function behaviors()
    {
        return array(
            'NestedSetBehavior'=>array(
                'class'=>'ext.behaviors.NestedSet.NestedSetBehavior',
                'leftAttribute'=>'lft',
                'rightAttribute'=>'rgt',
                'levelAttribute'=>'level',
        ));
    }

    /**
     * @param string $attr Attribute name
     * @param array $params Additional params
     */
    public function checkCategoryExists($attr, $params)
    {
        if (self::model()->count('id=:id',array(':id'=>$this->$attr))==0)
            $this->addError($attr, Yii::t('StoreModule.core','Ошибка проверки родительской категории.'));
        if ($this->id !== 1 && $this->id == $this->$attr)
            $this->addError($attr, Yii::t('StoreModule.core','Ошибка проверки родительской категории.'));
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
        );
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

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}
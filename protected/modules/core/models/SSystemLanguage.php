
<?php

/**
 * This is the model class for table "SystemLanguage".
 *
 * The followings are the available columns in table 'SystemLanguage':
 * @property integer $id
 * @property string $name Language name
 * @property string $code Url prefix
 * @property string $locale Language locale
 * @property boolean $default Is lang default
 */
class SSystemLanguage extends CActiveRecord
{

    private static $_languages;

    /**
     * Returns the static model of the specified AR class.
     * @return SSystemLanguage the static model class
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
        return 'SystemLanguage';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, code, locale', 'required'),
            array('name, locale', 'length', 'max'=>100),
            array('code', 'length', 'max'=>25),
            array('default', 'in', 'range'=>array(0,1)),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, code, locale', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => Yii::t('CoreModule.core', 'Название'),
            'code' => Yii::t('CoreModule.core', 'Идентификатор'),
            'locale' => Yii::t('CoreModule.core', 'Кодировка'),
            'default' => Yii::t('CoreModule.core', 'По умолчанию'),
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
        $criteria->compare('code',$this->code,true);
        $criteria->compare('locale',$this->locale,true);
        $criteria->compare('`default`',$this->default);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function afterSave()
    {
        // Leave only one default language
        if ($this->default)
        {
            self::model()->updateAll(array(
                'default'=>0,

            ), 'id!='.$this->id);
        }
    }
}
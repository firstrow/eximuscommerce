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
 * @property boolean $flag_name Flag image name
 */
class SSystemLanguage extends BaseModel
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
        return array(
            array('name, code, locale', 'required'),
            array('name, locale', 'length', 'max'=>100),
            array('flag_name', 'length', 'max'=>255),
            array('code', 'length', 'max'=>25),
            array('default', 'in', 'range'=>array(0,1)),
            array('id, name, code, locale', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'        => 'ID',
            'name'      => Yii::t('CoreModule.core', 'Название'),
            'code'      => Yii::t('CoreModule.core', 'Идентификатор'),
            'locale'    => Yii::t('CoreModule.core', 'Кодировка'),
            'default'   => Yii::t('CoreModule.core', 'По умолчанию'),
            'flag_name' => Yii::t('CoreModule.core', 'Флаг'),
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
            ), 'id != '.$this->id);
        }
        return parent::afterSave();
    }

    public function beforeDelete()
    {
        if($this->default)
            return false;
        return parent::beforeDelete();
    }

    public static function getFlagImagesList()
    {
        Yii::import('system.utils.CFileHelper');
        $flagsPath = 'application.modules.admin.assets.images.flags.png';

        $result = array();
        $flags  = CFileHelper::findFiles(Yii::getPathOfAlias($flagsPath));

        foreach($flags as $f)
        {
            $parts             = explode(DIRECTORY_SEPARATOR, $f);
            $fileName          = end($parts);
            $result[$fileName] = $fileName;
        }

        return $result;
    }
}
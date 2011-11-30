<?php

/**
 * TranslateBehavior implements the basic methods 
 * for translating dynamic content of models.
 * Behavoir takes language from SLanguageManager::active or you
 * can specify language id thru language() method.
 * 
 * Example: 
 * Find object with language id 2
 *     Object::model()->language(2)->find();
 * Detect language from array
 *     Object::model()->language($_GET)->find();
 * Language detected automatically
 *     Object::model()->find();
 *
 * Usage:
 * 1. Create new relation
 *  'translate'=>array(self::HAS_ONE, 'Translate Storage Model', 'foreign_id'),
 * 2. Attach behavior and enter translateable attributes
 *   'STranslateBehavior'=>array(
 *       'class'=>'ext.behaviors.STranslateBehavior',
 *       'translateAttributes'=>array(
 *           'title',
 *           'short_description',
 *           'full_description'
 *           etc...
 *       ),
 *   ),
 * 3. Set Model::$translateModelName - name of the model that handles translations.
 * 4. Create new db table to handle translated attribute values.
 *    Basic structure: id, object_id, language_id + attributes.
 * 5. Create 'Translate Storage Model' class and set $tableName.
 * 
 */
class STranslateBehavior extends CActiveRecordBehavior {
	
	/**
	 * @var array Model attributes aviable for translate
	 */
	public $translateAttributes = array();

    /**
     * @var integer Language id used to load model translation data.
     * If null active language id we'll be used.
     */
    private $_translation_lang;

    public function attach($owner)
    {
        return parent::attach($owner);
    }

    /** 
     * Merge object query with translate query.
     */
    public function beforeFind()
    {
        $this->owner->getDbCriteria()->mergeWith(array(
            'with'=>array('translate'=>array(
                'condition'=>'translate.language_id=:language_id',
                'params'=>array(
                    ':language_id'=>$this->getTranslateLanguageId()
                )
            )),
        ));
        return true;
    }

    /**
     * Get language id to load translated data.
     * @return integer Language id
     */
    public function getTranslateLanguageId()
    {
        if ($this->_translation_lang)
            return $this->_translation_lang;
        return Yii::app()->languageManager->active->id;
    }

	/**
	 * Apply object translation
	 */
    public function afterFind()
    {
        if($this->owner->translate)
        {
            foreach($this->translateAttributes as $attr)
                $this->owner->$attr = $this->owner->translate[$attr];
        }
        return true;
    }

    /**
     * Update model translations
     */
    public function afterSave()
    {
        $translate = $this->owner->translate;
        if ($this->owner->isNewRecord OR !$translate)
            $this->insertTranslations();
        else
            $this->updateTranslation($translate);
        return true;
    }

    /**
     * Create new object translation for each language.
     */
    public function insertTranslations()
    {
        $className = $this->owner->translateModelName;
        $ownerPk = $this->owner->getPrimaryKey();
        foreach (Yii::app()->languageManager->languages as $lang) 
        {
            $translate = new $className;
            $translate->object_id = $ownerPk;
            $translate->language_id = $lang->id;
            // Populate translated attributes
            foreach ($this->translateAttributes as $attr)
                $translate->$attr = $this->owner->$attr;
            $translate->save(false);
        }
    }

    /**
     * Update "current" translation object
     */
    public function updateTranslation($translate)
    {
        foreach ($this->translateAttributes as $attr)
            $translate->$attr = $this->owner->$attr;
        $translate->save(false);        
    }

    /**
     * Delete model related translations
     */
    public function afterDelete()
    {
        $className = $this->owner->translateModelName;
        $translate = $className::model()
            ->deleteAll('object_id=:id',array(
                ':id'=>$this->owner->getPrimaryKey()
            ));
        return true;
    }

    /**
     * Scope to load translation by language id
     * @param mixed $languageId or array containing `lang_id` key
     * @return CActiveRecord
     */
    public function language($language=null)
    {
        if(is_array($language) && isset($language['lang_id']))
            $language = $language['lang_id'];

        if(!Yii::app()->languageManager->getById($language))
            $language = Yii::app()->languageManager->default->id;
        
        $this->_translation_lang = $language;
        return $this->owner;
    }

}
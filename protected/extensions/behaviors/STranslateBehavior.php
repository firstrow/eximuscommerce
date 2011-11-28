<?php

/**
 * TranslateBehavior implements the basic methods 
 * for translating dynamic content of models.
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
	 * Attributes aviable for translate
	 */
	public $translateAttributes = array();


    public function attach($owner)
    {
        return parent::attach($owner);
    }

    /** 
     * Find by language
     */
    public function beforeFind()
    {
        $this->owner->getDbCriteria()->mergeWith(array(
            'with'=>array('translate'=>array(
                'condition'=>'language_id=1',
            )),
        ));

        return true;
    }

	/**
	 * Apply object translation
	 */
    public function afterFind()
    {
        if ($this->owner->translate)
        {
            foreach ($this->translateAttributes as $attr)
                $this->owner->$attr = $this->owner->translate[$attr];
        }

        return true;
    }

    public function afterSave()
    {
        $translate = $this->owner->translate;
        if (!$translate)
        {
            // Create new translation on default language.
            $className = $this->owner->translateModelName;
            $translate = new $className;
            $translate->object_id = $this->owner->getPrimaryKey();
            $translate->language_id = 1;
        }

        // Update existing translation
        foreach ($this->translateAttributes as $attr)
            $translate->$attr = $this->owner->$attr;
      
        $translate->save();
    }

    /**
     * Delete related translations
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

}
<?php

/**
 * Global events
 */
class PagesModuleEvents
{
    public function getEvents()
    {
        return array(
            array('SSystemLanguage', 'onAfterSave', array($this, 'insertTranslations')),
            array('SSystemLanguage', 'onAfterDelete', array($this, 'deleteTranslations')),
        );
    }

    /**
     * `On after create new language` event.
     * Create default translation for each page object.
     * @param $event
     * @return boolean
     */
    public function insertTranslations($event)
    {
        Yii::import('application.modules.pages.models.Page');

        if(!$event->sender->isNewRecord)
            return true;

        // Find all pages on default language and
        // make copy on new lang.
        $pages = Page::model()
            ->language(Yii::app()->languageManager->default->id)
            ->findAll();

        if($pages)
        {
            foreach($pages as $p)
                $p->createTranslation($event->sender->getPrimaryKey());
        }
    }

    /**
     * Delete page translations after deleting language
     * @param $event
     */
    public function deleteTranslations($event)
    {
        Yii::import('application.modules.pages.models.PageTranslate');

        $pages = PageTranslate::model()->findAll(array(
            'condition'=>'language_id=:lang_id',
            'params'=>array(':lang_id'=>$event->sender->getPrimaryKey())
        ));

        if($pages)
        {
            foreach($pages as $p)
                $p->delete();
        }
    }

}

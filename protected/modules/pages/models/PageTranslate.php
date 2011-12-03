<?php

/**
 * Class to access page translations
 *
 * @property int $id
 * @property int $object_id
 * @property int $language_id
 * @property string $title
 * @property string $short_description
 * @property string $full_description
 */
class PageTranslate extends CActiveRecord {

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'PageTranslate';
    }

}
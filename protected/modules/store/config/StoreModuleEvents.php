<?php

Yii::import('application.modules.store.models.StoreProduct');

/**
 * Global events
 */
class StoreModuleEvents
{

	/**
	 * @return array of events to subscribe module
	 */
	public function getEvents()
	{
		return array(
			array('SSystemLanguage', 'onAfterSave', array($this, 'insertTranslations')),
			array('SSystemLanguage', 'onAfterDelete', array($this, 'deleteTranslations')),
		);
	}

	/**
	 * `On after create new language` event.
	 * Create default translation for each product object.
	 * @param $event
	 */
	public function insertTranslations($event)
	{
		Yii::import('store.models.StoreProduct');

		if(!$event->sender->isNewRecord)
			return;

		// Find all products on default language and
		// make copy on new lang.
		$objects = StoreProduct::model()
			->language(Yii::app()->languageManager->default->id)
			->findAll();

		if($objects)
		{
			foreach($objects as $obj)
				$obj->createTranslation($event->sender->getPrimaryKey());
		}
	}

	/**
	 * Delete product translations after deleting language
	 * @param $event
	 */
	public function deleteTranslations($event)
	{
		$objects = StoreProductTranslate::model()->findAll(array(
			'condition'=>'language_id=:lang_id',
			'params'=>array(':lang_id'=>$event->sender->getPrimaryKey())
		));

		if($objects)
		{
			foreach($objects as $p)
				$p->delete();
		}
	}

}

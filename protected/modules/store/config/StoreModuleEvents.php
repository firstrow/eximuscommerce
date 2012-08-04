<?php

Yii::import('application.modules.store.models.*');

/**
 * Global events
 */
class StoreModuleEvents
{

	/**
	 * @var array
	 */
	public $classes = array(
		'StoreProduct',
		'StoreCategory',
		'StoreAttribute',
		'StoreManufacturer',
		'StoreDeliveryMethod',
	);

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
		if($event->sender->isNewRecord)
		{
			foreach($this->classes as $class)
				$this->_insert($class, $event);
		}
	}

	/**
	 * @param $class
	 * @param $event
	 */
	public function _insert($class, $event)
	{
		$objects = $class::model()
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
		foreach($this->classes as $class)
			$this->_delete($class.'Translate', $event);
	}

	/**
	 * @param $class
	 * @param $event
	 */
	private function _delete($class, $event)
	{
		$objects = $class::model()->findAll(array(
			'condition'=>'language_id=:lang_id',
			'params'=>array(':lang_id'=>$event->sender->getPrimaryKey())
		));

		if($objects)
		{
			foreach($objects as $obj)
				$obj->delete();
		}
	}

}

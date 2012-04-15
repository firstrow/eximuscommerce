<?php

Yii::import('application.modules.store.models.StoreManufacturer');
Yii::import('application.modules.store.models.StoreCategory');

/**
 * Global events
 */
class DiscountsModuleEvents
{

	/**
	 * @return array of events to subscribe module
	 */
	public function getEvents()
	{
		return array(
			array('StoreManufacturer', 'onAfterDelete', array($this, 'deleteManufacturer')),
			array('StoreCategory', 'onAfterDelete', array($this, 'deleteCategory')),
		);
	}

	/**
	 * @param $event CEvent
	 */
	public function deleteManufacturer($event)
	{
		Yii::app()->db->createCommand()->delete('DiscountManufacturer', 'manufacturer_id=:id', array(':id'=>$event->sender->getPrimaryKey()));
	}

	/**
	 * @param $event CEvent
	 */
	public function deleteCategory($event)
	{
		Yii::app()->db->createCommand()->delete('DiscountCategory', 'category_id=:id', array(':id'=>$event->sender->getPrimaryKey()));
	}

}

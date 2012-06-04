<?php

class Accounting1cModuleEvents
{

	/**
	 * @return array
	 */
	public function getEvents()
	{
		return array(
			array('StoreCategory', 'onAfterDelete', array($this, 'deleteExternalCategory')),
			array('StoreAttribute', 'onAfterDelete', array($this, 'deleteExternalAttribute')),
			array('StoreProduct', 'onAfterDelete', array($this, 'deleteExternalProduct')),
		);
	}

	/**
	 * @param $event
	 */
	public function deleteExternalCategory($event)
	{
		Yii::import('application.modules.accounting1c.components.C1ExternalFinder');
		$this->deleteRecord($event->sender, C1ExternalFinder::OBJECT_TYPE_CATEGORY);
	}

	/**
	 * @param $event
	 */
	public function deleteExternalAttribute($event)
	{
		Yii::import('application.modules.accounting1c.components.C1ExternalFinder');
		$this->deleteRecord($event->sender, C1ExternalFinder::OBJECT_TYPE_ATTRIBUTE);
	}

	/**
	 * @param $event
	 */
	public function deleteExternalProduct($event)
	{
		Yii::import('application.modules.accounting1c.components.C1ExternalFinder');
		$this->deleteRecord($event->sender, C1ExternalFinder::OBJECT_TYPE_PRODUCT);
	}

	/**
	 * @param CActiveRecord $model
	 * @param $type
	 */
	protected function deleteRecord(CActiveRecord $model, $type)
	{
		Yii::app()->db->createCommand()->delete('accounting1c', 'object_id=:object_id AND object_type=:object_type',array(
			':object_id'  =>$model->getPrimaryKey(),
			':object_type'=>$type,
		));
	}
}

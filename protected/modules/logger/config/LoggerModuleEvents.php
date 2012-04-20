<?php

Yii::import('application.modules.logger.models.ActionLog');

/**
 * LoggerModule events
 */
class LoggerModuleEvents
{

	/**
	 * @var array|null
	 */
	public $logClasses=null;

	/**
	 * @var array
	 */
	public $events = array('onBeforeSave', 'onAfterDelete');

	/**
	 * @var array cache saved objects to prevent double logging
	 */
	protected $processedObjects = array();

	/**
	 * Set classes to log
	 */
	public function __construct()
	{
		if($this->logClasses===null)
		{
			$this->logClasses = array(
				'StoreProduct'=>array(
					'title_attribute'=>'name'// Attribute name to get object human name.
				),
				'StoreCategory'=>array(
					'title_attribute'=>'name'// Attribute name to get object human name.
				),
				'StoreManufacturer'=>array(
					'title_attribute'=>'name'// Attribute name to get object human name.
				),
			);
		}
	}

	/**
	 * @return array
	 */
	public function getEvents()
	{
		$result = array();

		foreach($this->logClasses as $class=>$data)
		{
			foreach($this->events as $event)
			{
				$method = 'processEvent';
				if($event==='onAfterDelete')
					$method='processDeleteEvent';

				array_push($result, array($class, $event, array($this, $method)));
			}
		}

		return $result;
	}

	/**
	 * @param $event CEvent
	 * @return boolean
	 */
	public function processEvent($event)
	{
		if(Yii::app()->controller instanceof SAdminController === false)
			return true;

		$event->sender->isNewRecord ? $eventName=ActionLog::ACTION_CREATE:$eventName=ActionLog::ACTION_UPDATE;
		$this->saveEvent($event->sender, $eventName);

		return true;
	}

	/**
	 * @param $event CEvent
	 * @return boolean
	 */
	public function processDeleteEvent($event)
	{
		if(Yii::app()->controller instanceof SAdminController === false)
			return true;

		$this->saveEvent($event->sender, ActionLog::ACTION_DELETE);

		return true;
	}

	/**
	 * @param $model
	 * @param $event string event name. e.g: create/update/delete
	 */
	protected function saveEvent($model, $event)
	{
		if(in_array(spl_object_hash($model),$this->processedObjects))
			return;

		$className = get_class($model);
		$modelTitleAttr = $this->logClasses[$className]['title_attribute'];

		$log = new ActionLog;
		$log->username = Yii::app()->user->username;
		$log->event = $event;
		$log->model_name = $className;
		$log->model_title = $model->$modelTitleAttr;
		$log->datetime = date('Y-m-d H:i:s');
		$log->save();

		array_push($this->processedObjects, spl_object_hash($model));
	}
}

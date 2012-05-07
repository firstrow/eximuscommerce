<?php

class BaseModel extends CActiveRecord {

	/**
	 * Initialize component
	 */
	public function init()
	{
		SModelEventManager::attachEvents($this);
	}

}
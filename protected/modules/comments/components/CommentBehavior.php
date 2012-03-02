<?php

/**
 * Behavior for commentabe models
 */
class CommentBehavior extends CBehavior
{

	/**
	 * @var string model primary key attribute
	 */
	public $pk = 'id';

	/**
	 * @var string alias to class. e.g: application.store.models.StoreProduct or pages.models.Page
	 */
	public $class_name;

	/**
	 * @var string attribute name to present comment owner in admin panel. e.g: name - refernces to Page->name
	 */
	public $owner_title;

	/**
	 * @return string pk name
	 */
	public function getObjectPkAttribute()
	{
		return $this->pk;
	}

	public function getClassName()
	{
		return $this->class_name;
	}

	public function getOwnerTitle()
	{
		$attr = $this->owner_title;
		return $this->getOwner()->$attr;
	}

	/**
	 * @param CEvent $event
	 * @return mixed
	 */
	public function afterDelete($event)
	{
		Comment::model()->deleteAllByAttributes(array(
			'class_name'=>get_class($this->getOwner()),
		));
		return parent::afterDelete($event);
	}
}

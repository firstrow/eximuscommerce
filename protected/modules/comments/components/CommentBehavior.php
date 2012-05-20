<?php

/**
 * Behavior for commentabe models
 */
class CommentBehavior extends CActiveRecordBehavior
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
	 * @var string attribute name to present comment owner in admin panel. e.g: name - references to Page->name
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

	public function attach($owner)
	{
		parent::attach($owner);
	}

	/**
	 * @param CEvent $event
	 * @return mixed
	 */
	public function afterDelete($event)
	{
		Yii::import('application.modules.comments.models.Comment');

		$pk = $this->getObjectPkAttribute();
		Comment::model()->deleteAllByAttributes(array(
				'class_name'=>$this->getClassName(),
				'object_pk'=>$this->getOwner()->$pk
		));
		return parent::afterDelete($event);
	}

	/**
	 * @return string approved comments count for object
	 */
	public function getCommentsCount()
	{
		Yii::import('application.modules.comments.models.Comment');

		$pk = $this->getObjectPkAttribute();
		return Comment::model()
			->approved()
			->countByAttributes(array(
			'class_name'=>$this->getClassName(),
			'object_pk'=>$this->getOwner()->$pk
		));
	}
}

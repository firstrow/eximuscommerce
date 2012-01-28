<?php

/**
 * Render product attributes table.
 * Basically used on product view page.
 */
class SAttributesTableRenderer extends CWidget
{

	/**
	 * @var BaseModel with EAV behavior enabled
	 */
	public $model;

	/**
	 * @var array model attributes loaded with getEavAttributes method
	 */
	protected $_attributes;

	/**
	 * @var array of StoreAttribute models
	 */
	protected $_models;

	public function run()
	{
		$this->_attributes = $this->model->getEavAttributes();

		$data = array();

		foreach($this->_attributes as $name=>$value)
		{
			$attributeModel = $this->models[$name];
			$data[$attributeModel->title] = $attributeModel->renderValue($value);
		}

		if(!empty($data))
		{
			var_dump(array_reverse($data));
		}

	}

	/**
	 * @return array of used attribute models
	 */
	public function getModels()
	{
		if (is_array($this->_models))
			return $this->_models;

		$this->_models = array();
		$cr = new CDbCriteria;
		$cr->addInCondition('t.name', array_keys($this->_attributes));

//		foreach(StoreAttribute::model()->with(array('options'))->findAll($cr) as $m)
		foreach(StoreAttribute::model()->findAll($cr) as $m)
			$this->_models[$m->name] = $m;

		return $this->_models;
	}
}

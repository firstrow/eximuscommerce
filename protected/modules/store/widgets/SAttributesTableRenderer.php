<?php

/**
 * Render product attributes table.
 * Basically used on product view page.
 * Usage:
 *     $this->widget('application.modules.store.widgets.SAttributesTableRenderer', array(
 *        // SProduct model
 *        'model'=>$model,
 *         // Optional. Html table attributes.
 *        'htmlOptions'=>array('class'=>'...', 'id'=>'...', etc...)
 *    ));
 */
class SAttributesTableRenderer extends CWidget
{

	/**
	 * @var BaseModel with EAV behavior enabled
	 */
	public $model;

	/**
	 * @var array table element attributes
	 */
	public $htmlOptions = array();

	/**
	 * @var array model attributes loaded with getEavAttributes method
	 */
	protected $_attributes;

	/**
	 * @var array of StoreAttribute models
	 */
	protected $_models;

	/**
	 * Render attributes table
	 */
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
			echo CHtml::openTag('table', $this->htmlOptions);
			foreach(array_reverse($data) as $title=>$value)
			{
				echo CHtml::openTag('tr');
				echo '<td>'.CHtml::encode($title).'</td>';
				echo '<td>'.CHtml::encode($value).'</td>';
				echo CHtml::closeTag('tr');
			}
			echo CHtml::closeTag('table');
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
		$cr->addInCondition('StoreAttribute.name', array_keys($this->_attributes));

		foreach(StoreAttribute::model()->with(array('options'))->findAll($cr) as $m)
			$this->_models[$m->name] = $m;

		return $this->_models;
	}
}
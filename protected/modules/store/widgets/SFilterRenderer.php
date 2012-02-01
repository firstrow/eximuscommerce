<?php

/**
 * Base class to render attributes in sidebar to filter products.
 * Usage:
 * $this->widget('application.modules.store.widgets.SFilterRenderer', array(
 *      // StoreCategory model. Used to create url
 *      'model'=>$model,
 *      'attributes'=>$usedAttributes
 *  ));
 */
class SFilterRenderer extends CWidget
{

	/**
	 * @var array of StoreAttribute models
	 */
	public $attributes;

	/**
	 * @var StoreCategory
	 */
	public $model;

	/**
	 * @var string Tag to surround attribute title.
	 */
	public $titleTag = 'h5';

	/**
	 * Render filter
	 */
	public function run()
	{
		foreach($this->attributes as $attribute)
		{
			echo CHtml::openTag($this->titleTag);
			echo $attribute->title;
			echo CHtml::closeTag($this->titleTag);

			echo CHtml::openTag('ul');
			foreach($attribute->options as $option)
			{
				echo CHtml::openTag('li');
				echo CHtml::link($option->value, $this->addUrlParam(array('url'=>$this->model->url, $attribute->name=>$option->id)));
				echo CHtml::closeTag('li');
			}
			echo CHtml::openTag('ul');
		}
	}

	/**
	 * Add param to current url. Url is based on $data and $_GET arrays
	 * @param $data array of the data to add to the url.
	 * @return string
	 */
	public function addUrlParam($data)
	{
		return Yii::app()->createUrl('/store/category/view', CMap::mergeArray($_GET, $data));
	}
}

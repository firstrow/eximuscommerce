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

	public $criteria;

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
				$htmlOptions = array();
				$v = $this->count($attribute, $option);
				echo CHtml::openTag('li');
				if($v>0)
				{
					$url = $this->addUrlParam(array('url'=>$this->model->url, $attribute->name=>$option->id));
					if(Yii::app()->request->getQuery($attribute->name) == $option->id)
						echo CHtml::link($option->value, $url, array('style'=>'color:green'));
					else
						echo CHtml::link($option->value.'('.$v.')', $url, $htmlOptions);
				}
				else
					echo CHtml::encode($option->value.'(0)');
				echo CHtml::closeTag('li');
			}
			echo CHtml::closeTag('ul');
		}
	}

	public function count($attribute, $option)
	{
		$model = new StoreProduct(null);
		$model->attachBehaviors($model->behaviors());

		$cr = new CDbCriteria;
		$cr->select = 't.id';
		$cr->join = 'LEFT OUTER JOIN `StoreProductCategoryRef` `categorization` ON (`categorization`.`product`=`t`.`id`)';
		$cr->condition = 'categorization.category='.$this->model->id;

		return $model->withEavAttributes(array($attribute->name=>$option->id))->count($cr);
	}

	/**
	 * @return array of category manufacturers
	 */
	public function getCategoryManufacturers()
	{
		$builder  = new CDbCommandBuilder(Yii::app()->db->getSchema());
		$criteria = new CDbCriteria;

		$criteria->select    = 'manufacturer_id';
		$criteria->group     = 'manufacturer_id';
		$criteria->condition = 'manufacturer_id IS NOT NULL';
		$criteria->distinct  = true;
		$manufacturers = $builder->createFindCommand(StoreProduct::tableName(), $criteria)->queryColumn();

		return StoreManufacturer::model()->findAllByPk($manufacturers);
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

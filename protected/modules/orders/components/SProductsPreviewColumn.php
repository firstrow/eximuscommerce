<?php

/**
 * Column to render ordered products preview
 */
class SProductsPreviewColumn extends CGridColumn
{

	/**
	 * @var string url to assets directory
	 */
	public $baseUrl;

	/**
	 * Register column componenets
	 */
	public function init()
	{
		$cs=Yii::app()->clientScript;
		$this->baseUrl=$this->grid->owner->module->assetsUrl.'/previewColumn';
		$cs->registerScriptFile($this->baseUrl.'/core.js', CClientScript::POS_END);
		$cs->registerCssFile($this->baseUrl.'/style.css', CClientScript::POS_HEAD);
	}

	/**
	 * Renders column content
	 * @param int $row
	 */
	public function renderDataCellContent($row)
	{
		$order=$this->grid->dataProvider->data[$row];
		echo CHtml::image($this->baseUrl.'/trolley.png', '', array(
			'id'=>$order->id,
			'class'=>'productPreview',
		));
	}
}

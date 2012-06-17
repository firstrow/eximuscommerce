<?php

class SJsTree extends CWidget
{
	/**
	 * @var string Id of elements
	 */
	public $id;

	/**
	 * @var array of nodes. Each node must contain next attributes:
	 *  id - If of node
	 *  name - Name of none
	 *  hasChildren - boolean has node children
	 *  children - get children array
	 */
	public $data = array();

	/**
	 * @var array jstree options
	 */
	public $options = array();

	/**
	 * @var CClientScript
	 */
	protected $cs;

	/**
	 * Initialize widget
	 */
	public function init()
	{
		$assetsUrl = Yii::app()->getAssetManager()->publish(
			Yii::getPathOfAlias('ext.jstree.assets'),
			false,
			-1,
			YII_DEBUG
		);

		Yii::app()->getClientScript()->registerPackage('cookie');

		$this->cs = Yii::app()->getClientScript();
		$this->cs->registerScriptFile($assetsUrl.'/jquery.jstree.js');
	}

	public function run()
	{
		echo CHtml::openTag('div', array(
			'id'=>$this->id,
		));
		echo CHtml::openTag('ul');
		$this->createHtmlTree($this->data);
		echo CHtml::closeTag('ul');
		echo CHtml::closeTag('div');

		$options = CJavaScript::encode($this->options);

		$this->cs->registerScript('JsTreeScript', "
			$('#{$this->id}').jstree({$options});
		");
	}

	/**
	 * Create ul html tree from data array
	 * @param string $data
	 */
	private function createHtmlTree($data)
	{
		foreach($data as $node)
		{
			echo CHtml::openTag('li', array(
				'id'=>$this->id.'Node_'.$node['id']
			));
			echo CHtml::link(CHtml::encode($node->name));
			if ($node['hasChildren'] === true)
			{
				echo CHtml::openTag('ul');
				$this->createHtmlTree($node['children']);
				echo CHtml::closeTag('ul');
			}
			echo CHtml::closeTag('li');
		}
	}

}

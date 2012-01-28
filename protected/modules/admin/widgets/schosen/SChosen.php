<?php
/**
 * Usage:
 * $this->widget('application.modules.admin.widgets.schosen.SChosen', array(
 *		'elements'=>array('id1','id2')
 *	));
 */

Yii::import('application.modules.admin.AdminModule');

class SChosen extends CWidget {

	/**
	 * @var array List of objects id
	 */
	private $_elements;

	public function run()
	{
		$this->registerScripts();
	}

	public function setElements($elements)
	{
		$cs = Yii::app()->getClientScript();
		foreach($elements as $objectId)
		{
			$cs->registerScript($objectId.'Chosen', '
				$("#'.$objectId.'").chosen({no_results_text: "'.Yii::t('AdminModule.core', 'Ничего не найдено').'"});
			');
		}
	}

	public function registerScripts()
	{
		$assetsUrl=Yii::app()->getAssetManager()->publish(
			Yii::getPathOfAlias('application.modules.admin.widgets.schosen.assets'),
			true,
			-1,
			YII_DEBUG
		);

		$cs = Yii::app()->getClientScript();
		$cs->registerCssFile($assetsUrl.'/chosen.css');
		$cs->registerScriptFile($assetsUrl.'/chosen.jquery.js');
	}

}
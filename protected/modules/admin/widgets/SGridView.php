<?php 

Yii::import('zii.widgets.grid.CGridView');

// $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
//     'id'=>'mydialog',
//     // additional javascript options for the dialog plugin
//     'options'=>array(
//         'title'=>'Dialog box 1',
//         'modal'=>true,
//         'resizable'=>false,
//         'draggable'=>false,
//         'autoOpen'=>false,
//         'buttons'=>array(
//             'Сохранить'=>'js:function(){alert("ok")}',
//             'Отмена'=>'js:function(){alert("cancel")}',
//         ),
//     ),
// ));

// echo 'dialog content here';

// $this->endWidget('zii.widgets.jui.CJuiDialog');

// // the link that may open the dialog
// echo CHtml::link('open dialog', '#', array(
//    'onclick'=>'$("#mydialog").dialog("open"); return false;',
// ));

/**
 * Extends yii gridview and adds several new features as: "Clear/Save filter", 
 * ability to add personal menu.
 * 
 * @package admin.widgets
 */
class SGridView extends CGridView {
	
	public $template = '{items}{summary}{pager}';
	public $selectableRows = 100;

	/**
	 * Initializes the grid view.
	 */
	public function init()
	{
		// Uhhhh! ugly copypaste from CBaseListView::init()!
		if($this->dataProvider===null)
			throw new CException(Yii::t('zii','The "dataProvider" property cannot be empty.'));

		$this->dataProvider->getData();

		$this->htmlOptions['id']=$this->getId();

		if($this->enableSorting && $this->dataProvider->getSort()===false)
			$this->enableSorting=false;
		if($this->enablePagination && $this->dataProvider->getPagination()===false)
			$this->enablePagination=false;
		// End of ugly

		if(!isset($this->htmlOptions['class']))
			$this->htmlOptions['class']='grid-view';

		if($this->baseScriptUrl===null)
			$this->baseScriptUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.modules.admin.assets'),
				true,
				-1,
				YII_DEBUG
			).'/gridview';

		if($this->cssFile!==false)
		{
			if($this->cssFile===null)
				$this->cssFile=$this->baseScriptUrl.'/styles.css';
			Yii::app()->getClientScript()->registerCssFile($this->cssFile);
		}

		Yii::app()->getClientScript()->registerScriptFile($this->baseScriptUrl.'/gridview.dropdown.js',CClientScript::POS_END);

		$this->pager = array(
			'cssFile'=>$this->baseScriptUrl.'/pager.css',
		);

		$this->initColumns();
	}

	/**
	 * Renders the data items for the grid view.
	 */
	public function renderItems()
	{
		$this->insertDropdownHtml();
		$this->insertModelAttributes();
		parent::renderItems();
	}

	/**
	 * Display current model attributes as json string in hidden block
	 * for "save filter" js function.
	 */
	public function insertModelAttributes()
	{
		if ($this->filter->attributes)
		{
			$attrs = $this->filter->attributes;

			foreach ($attrs as $key => $value) 
				if(!$value) unset($attrs[$key]);

			if (!empty($attrs))
			{
				echo Chtml::openTag('div', array(
					'id'=>$this->getId().'HiddenJsonAttributes',
					'style'=>'display:none',
				));
				echo json_encode($attrs);
				echo CHtml::closeTag('div');
			}
		}
	}

	/**
	 * Insert dropdown menu html code.
	 */
	public function insertDropdownHtml()
	{
		echo '
			<div class="gridViewOptions">&nbsp;</div>
			<div class="gridViewOptionsMenu">
				<ul>
				<li><a href="#" onClick="clearSGridViewFilter(\''.$this->getId().'\');">Очистить фильтр</a></li>
				<li><a href="#" onClick="saveSGridViewFilter(\''.$this->getId().'\');">Сохранить фильтр</a></li>
				</ul>
			</div>
		';

		echo CHtml::openTag('div', array(
			'id'=>'mydialog',
		));
		echo 'dialog content here';
		echo CHtml::closeTag('div');
		
		echo Chtml::script("jQuery('#mydialog').dialog({
			'title':'Dialog box 1',
			'modal':true,
			'resizable':false,
			'draggable':false,
			'autoOpen':false,
			'buttons':{
				'Сохранить':function(){alert(\"ok\")},
				'Отмена':function(){alert(\"cancel\")}
				}
			});");

	}
}
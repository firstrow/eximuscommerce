<?php 

Yii::import('zii.widgets.grid.CGridView');

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
		parent::renderItems();
	}

	/**
	 * Insert dropdown menu html code.
	 */
	public function insertDropdownHtml()
	{
		echo '
			<div class="gridViewOptions">&nbsp;</div>
			<div class="gridViewOptionsMenu">
				<a href="#" onClick="clearSGridViewFilter(\''.$this->getId().'\');">Очистить фильтр</a><br/>
				<a href="#">Сохранить фильтр</a><br/>
				<hr/>
				<a href="#">Most Popular</a><br/>
				<a href="#">My pages</a><br/>				
			</div>
		';		
	}
}
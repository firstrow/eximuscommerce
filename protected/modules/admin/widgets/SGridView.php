<?php 

Yii::import('zii.widgets.grid.CGridView');
Yii::import('application.modules.core.models.GridViewFilter');

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

		// Load custom filter.
		if (isset($_GET['loadFilter']))
		{
			$filter = GridViewFilter::model()->findByAttributes(array(
				'grid_id'=>$this->getId(),
				'user_id'=>Yii::app()->user->id,
				'id'=>$_GET['loadFilter']
			));

			if ($filter)
			{
				foreach(json_decode($filter->data) as $key=>$val)
				{
					$this->filter->$key = $val;
				}
			}
		}

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
		$filters = GridViewFilter::model()->findAllByAttributes(array(
			'grid_id'=>$this->getId(),
			'user_id'=>Yii::app()->user->id
		));

		$filtersHtml = '';
		if ($filters)
		{
			$filtersHtml = '<hr>';
			foreach ($filters as $filter) 
			{
				$filtersHtml .= strtr('<li><a href="#" onClick="return loadSGridViewFilterById(\'{gridId}\',{filterId})">{name}</a></li>', array(
					'{name}'=>CHtml::encode($filter->name),
					'{gridId}'=>$this->getId(),
					'{filterId}'=>$filter->id,
				));
			}
		}
			
		echo '
			<div class="gridViewOptions">&nbsp;</div>
			<div class="gridViewOptionsMenu">
				<ul>
					<li><a href="#" onClick="clearSGridViewFilter(\''.$this->getId().'\');">Очистить фильтр</a></li>
					<li><a href="#" onClick="$(\'#'.$this->getId().'saveFilterDialog\').dialog(\'open\');">Сохранить фильтр</a></li>
					'.$filtersHtml.'
				</ul>
			</div>
		';
		echo CHtml::openTag('div', array(
			'id'=>$this->getId().'saveFilterDialog',
		));
		echo '
			<div class="form">
				<div class="row">
					<input type="text" id="'.$this->getId().'FilterBox" maxlength="255" value="'.rand(1,100).'">
					<div class="hint">Enter field name and press enter</div>
				</div>
			</div>
		';
		echo CHtml::closeTag('div');
		echo Chtml::script("jQuery('#".$this->getId()."saveFilterDialog').dialog({
			'title':'Сохранить фильтр',
			'modal':true,
			'resizable':false,
			'draggable':false,
			'autoOpen':false,
			'YII_CSRF_TOKEN': '".Yii::app()->request->csrfToken."',
			'buttons':{
				'Сохранить':function(){saveSGridViewFilter('".$this->getId()."')},
				'Отмена':function(){\$(this).dialog('close');}
			}
		});");
	}
}
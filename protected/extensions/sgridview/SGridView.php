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
	public $selectableRows = 2;
	public $extended = true;

    public $selectionChanged;

    /**
     * @var array List of custom actions to display in footer.
     * See example in {@link SGridView::getFooterActions}
     */
    public $customActions = array();

	/**
	 * Initializes the grid view.
	 */
	public function init()
	{
		// Uhhhh! ugly copy-paste from CBaseListView::init()!
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
		{
			$this->baseScriptUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('ext.sgridview.assets'),
				true,
				-1,
				YII_DEBUG
			);
		}

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

        $this->setSelectionChanged();
		$this->initColumns();
	}

	/**
	 * Renders the data items for the grid view.
	 */
	public function renderItems()
	{
		if ($this->extended && $this->filter)
		{
			$this->insertDropdownHtml();
			$this->insertModelAttributes();
		}

		parent::renderItems();

        $this->widget('zii.widgets.CMenu', array(
            'id'=>$this->getId().'Actions',
            'htmlOptions'=>array(
                'class'=>'gridFooterActions',
            ),
            'items'=>$this->getFooterActions(),
        ));
	}

    public function getFooterActions()
    {
        $deleteAction = array(array(
                'label'=>'Удалить',
                'url'=>$this->owner->createUrl('delete'),
                'linkOptions'=>array(
                    'class'=>'actionDelete',
                    'data-token'=>Yii::app()->request->csrfToken,
                    'data-question'=>Yii::t('SGridView.core', 'Вы действительно хотите удалить выбранные страницы?'),
                    'onClick'=>strtr('return $.fn.yiiGridView.runAction(":grid", this);', array(
                        ':grid'=>$this->getId()
                    )),
                ),
            ));
        return CMap::mergeArray($this->customActions, $deleteAction);
    }

    /**
     * Set js function on grid row click.
     */
    public function setSelectionChanged()
    {
        $this->selectionChanged = 'function(id){$.fn.yiiGridView.showActions(id)}';
    }

	/**
	 * Display current model attributes as json string in hidden block
	 * for "save filter" js function.
	 */
	public function insertModelAttributes()
	{
		if ($this->filter->attributes)
		{
			$attrs = array();

			foreach ($this->filter->attributes as $key => $value)
			{
				if($value)
					$attrs[get_class($this->filter).'['.$key.']'] = $value;
			}

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
	 * Check if filter attributes is not empty.
	 * @return boolean
	 */
	public function _checkAttributes()
	{
		if($this->filter->attributes)
		{
			foreach($this->filter->attributes as $val)
			{
				if($val)
					return true;
			}
		}
		return false;
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
			$filtersHtml .= CHtml::openTag('hr');
			foreach ($filters as $filter)
			{
				$filtersHtml .= strtr('
					<li>
						<div style="clear:both;">
							<div style="float:left;">
								<a href="#" onClick="return loadSGridViewFilterById(\'{gridId}\',{filterId})">{name}</a>
							</div>
							<div style="float:right;">
								{delete}
							</div>
						</div>
					</li>', array(
					'{name}'=>CHtml::encode($filter->name),
					'{gridId}'=>$this->getId(),
					'{filterId}'=>$filter->id,
					'{delete}'=>CHtml::link(
					    CHtml::image($this->baseScriptUrl.'/cross.png', Yii::t('SGridView.core', 'Удалить')),
					    array(
						     '/admin/core/gridView/deleteFilter',
						     'id'=>$filter->id,
						     'redirect'=>base64_encode(Yii::app()->request->url),
						),
					    array(
						    'confirm'=>Yii::t('SGridView.core','Вы действительно хотите удалить этот фильтр?'),
						    'id'=>'fdLink'.$filter->id
						)
					)
				));
			}
		}

		echo strtr('
			<div class="gridViewOptions">&nbsp;</div>
			<div class="gridViewOptionsMenu">
				<ul>
					<li>
						<a href="#" onClick="clearSGridViewFilter(\''.$this->getId().'\');">'.Yii::t('SGridView.core','Очистить фильтр').'</a>
					</li>
					<li>{saveLink}</li>
					'.$filtersHtml.'
				</ul>
			</div>', array(
				'{saveLink}'=>$this->_checkAttributes() ? '<a href="#" onClick="$(\'#'.$this->getId().'saveFilterDialog\').dialog(\'open\');">'.Yii::t('SGridView.core','Сохранить фильтр').'</a>':'<a class="nonActive">'.Yii::t('SGridView.core','Сохранить фильтр').'</a>',
			));
		echo CHtml::openTag('div', array(
			'id'=>$this->getId().'saveFilterDialog',
		));
		echo '
			<div class="form">
				<div class="row">
					<input type="text" id="'.$this->getId().'FilterBox" maxlength="255">
					<div class="hint">'.Yii::t('SGridView.core','Укажите имя фильтра').'</div>
				</div>
			</div>
		';
		echo CHtml::closeTag('div');

		echo $this->createSaveDialog();
	}

	protected function createSaveDialog()
	{
		return Chtml::script("jQuery('#".$this->getId()."saveFilterDialog').dialog({
			'title':'".Yii::t('SGridView.core','Сохранить фильтр')."',
			'modal':true,
			'resizable':false,
			'draggable':false,
			'autoOpen':false,
			'YII_CSRF_TOKEN': '".Yii::app()->request->csrfToken."',
			'buttons':{
				'".Yii::t('SGridView.core','Сохранить')."':function(){saveSGridViewFilter('".$this->getId()."')},
				'".Yii::t('SGridView.core','Отмена')."':function(){\$(this).dialog('close');}
			}
		});");
	}
}
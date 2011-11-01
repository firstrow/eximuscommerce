<?php 

Yii::import('zii.widgets.grid.CGridView');

class SGridView extends CGridView {
	
	public $template = '{items}{summary}{pager}';

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

		$this->initColumns();
	}


	/**
	 * Renders the data items for the grid view.
	 */
	public function renderItems()
	{
		if($this->dataProvider->getItemCount()>0 || $this->showTableOnEmpty)
		{
			$this->insertDropdownHtml();
			$this->registerDropdownScript();

			echo "<table class=\"{$this->itemsCssClass}\">\n";
			$this->renderTableHeader();
			ob_start();
			$this->renderTableBody();
			$body=ob_get_clean();
			$this->renderTableFooter();
			echo $body; // TFOOT must appear before TBODY according to the standard.
			echo "</table>";
		}
		else
			$this->renderEmptyText();
	}

	/**
	 * Insert dropdown menu html code.
	 */
	public function insertDropdownHtml()
	{
		echo '
			<div class="gridViewOptions">&nbsp;</div>
			<div class="gridViewOptionsMenu">
				<a href="#">Clear filter</a><br/>
				<a href="#">Save filter</a><br/>
				<hr/>
				<a href="#">Most Popular</a><br/>
				<a href="#">My pages</a><br/>				
			</div>
		';		
	}

	public function registerDropdownScript()
	{
		Yii::app()->getClientScript()->registerScript("gridViewOptionsScript","
			(function($){
			    $.fn.fixedMenu=function(){
			        return this.each(function(){
			            var menu = $(this);
			            menu.click(function(){
			            	if (menu.hasClass('active'))
			            	{
			            		// hide
			            		menu.removeClass('active');
			            		menu.next('.gridViewOptionsMenu').css('display', 'none');
			            	}else{
			            		// show
			            		menu.addClass('active');
			            		menu.next('.gridViewOptionsMenu').css('display', 'block');				            		
			            	}
			            });

						/* hide when clicked outside */
						$(document.body).bind('click',function(e) {
							if( !$(e.target).hasClass('gridViewOptions') && !$(e.target).hasClass('gridViewOptionsMenu') )
							{
			            		menu.removeClass('active');
			            		menu.next('.gridViewOptionsMenu').css('display', 'none');									
							}
						});
						            
			        });
			    }
			})(jQuery);

			$('document').ready(function(){
	          	$('.gridViewOptions').fixedMenu();
	        });

		", CClientScript::POS_HEAD);
	}

}
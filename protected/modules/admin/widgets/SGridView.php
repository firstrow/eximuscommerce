<?php 

Yii::import('zii.widgets.grid.CGridView');

class SGridView extends CGridView {
	
	public $cssFile = false;
	public $template = '{items}{summary}{pager}';

	/**
	 * Renders the data items for the grid view.
	 */
	public function renderItems()
	{
		if($this->dataProvider->getItemCount()>0 || $this->showTableOnEmpty)
		{
			echo '
				<div class="gridViewOptions">
					&nbsp;
				</div>
			';
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

}
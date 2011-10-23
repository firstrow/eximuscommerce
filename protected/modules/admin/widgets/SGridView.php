<?php 

Yii::import('zii.widgets.grid.CGridView');

class SGridView extends CGridView {
	
	public $cssFile = false;
	public $template = '{items}{summary}{pager}';

}
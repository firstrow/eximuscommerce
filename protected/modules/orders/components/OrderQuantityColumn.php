<?php

class OrderQuantityColumn extends CDataColumn
{
	public function renderHeaderCell()
	{
		$this->headerHtmlOptions['width']='30px';
		parent::renderHeaderCell();
	}

	public function renderDataCellContent($row, $data)
	{
		$data = array(
			'{name}'  => 'quantity['.$data->id.']',
			'{value}' => $data->quantity,
		);
		echo strtr('<input type="text" name="{name}" value="{value}" class="order_quantity_short">', $data);
	}
}
<?php

Yii::import('ext.elrte.SElrteArea');

/**
 * Draw textarea widget
 */
class SRichTextarea extends SElrteArea
{
	public function setModel($model)
	{
		$this->model=$model;
	}
}

<?php

Yii::import('ext.tinymce.STinyMceArea');

/**
 * Draw textarea widget
 */
class SRichTextarea extends STinyMceArea
{
	public function setModel($model)
	{
		$this->model=$model;
	}
}

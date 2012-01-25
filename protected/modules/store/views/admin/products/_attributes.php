<?php

	$attributes = StoreAttribute::model()->findAll();

	foreach($attributes as $a)
	{
		echo CHtml::openTag('div', array('class'=>'row'));
		echo CHtml::label($a->title, $a->name);
		echo $a->renderField();
		echo CHtml::closeTag('div');
	}

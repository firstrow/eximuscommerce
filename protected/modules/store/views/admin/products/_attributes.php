<?php

	/**
	 * Product update.
	 * Options tab.
	 */

	if ($model->type)
	{
		$attributes = $model->type->storeAttributes;

		if(empty($attributes))
			echo Yii::t('StoreModule.admin', 'Список свойств пустой');
		else
		{
			foreach($attributes as $a)
			{
				echo CHtml::openTag('div', array('class'=>'row'));
				echo CHtml::label($a->title, $a->name);
				echo '<div class="rowInput">'.$a->renderField($model).'</div>';
				echo CHtml::closeTag('div');
			}
		}
	}
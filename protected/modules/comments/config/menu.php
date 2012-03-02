<?php

Yii::import('comments.CommentsModule');

/**
 * Admin menu items for pages module
 */
return array(
	'cms'=>array(
		'items'=>array(
			array(
				'label'=>Yii::t('CommentsModule.core', 'Комментарии'),
				'url'=>array('/comments/admin/index'),
				'position'=>4
			),
		)
	),
);
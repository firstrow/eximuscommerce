<?php

/**
 * @var $this SSystemMenu
 */

Yii::import('comments.CommentsModule');

/**
 * Admin menu items for pages module
 */
return array(
	array(
		'label'    => Yii::t('CommentsModule.core', 'Комментарии'),
		'url'      => array('/comments/admin/index'),
		'position' => 4,
		'itemOptions' => array(
			'class'       => 'hasRedCircle circle-comments',
		),
	),
);
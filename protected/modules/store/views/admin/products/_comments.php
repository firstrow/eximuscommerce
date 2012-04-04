<?php

/**
 * Product comments
 *
 * @var $model StoreProduct
 */

$module = Yii::app()->getModule('comments');
Yii::import('comments.models.Comment');
$comments = new Comment('search');

if(!empty($_GET['Comment']))
	$comments->attributes = $_GET['Comment'];

$comments->class_name = 'store.models.StoreProduct';
$comments->object_pk  = $model->id;

$dataProvider = $comments->search();
$dataProvider->pagination->pageSize = Yii::app()->params['adminPageSize'];

$this->widget('ext.sgridview.SGridView', array(
	'dataProvider' => $dataProvider,
	'id'           => 'commentsListGrid',
	'filter'       => $comments,
	'ajaxUrl'      => Yii::app()->createUrl('/store/admin/products/applyCommentsFilter', array('product_id'=>$model->id)),
	'columns' => array(
		array(
			'class'=>'CCheckBoxColumn',
		),
		array(
			'class'=>'SGridIdColumn',
			'name'=>'id',
		),
		array(
			'name'  => 'name',
			'type'  => 'raw',
			'value' => 'CHtml::link(CHtml::encode($data->name), array("update", "id"=>$data->id))',
		),
		array(
			'name'=>'email',
		),
		array(
			'name'=>'text',
			'value'=>'Comment::truncate($data, 100)'
		),
		array(
			'name'=>'status',
			'filter'=>Comment::getStatuses(),
			'value'=>'$data->statusTitle',
		),
		array(
			'name'=>'created',
		),
		// Buttons
		array(
			'class'=>'CButtonColumn',
			'updateButtonUrl'=>'Yii::app()->createUrl("/comments/admin/comments/update", array("id"=>$data->id))',
			'deleteButtonUrl'=>'Yii::app()->createUrl("/comments/admin/comments/delete", array("id"=>$data->id))',
			'template'=>'{update}{delete}',
		),
	),
));
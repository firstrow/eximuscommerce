<?php

/**
 * Product comments
 *
 * @var $model StoreProduct
 */
Yii::import('comments.models.Comment');

$module = Yii::app()->getModule('comments');
$comments = new Comment('search');

if(!empty($_GET['Comment']))
	$comments->attributes = $_GET['Comment'];

$comments->class_name = 'application.modules.store.models.StoreProduct';
$comments->object_pk  = $model->id;

// Fix sort url
$dataProvider = $comments->search();
$dataProvider->pagination->pageSize = Yii::app()->settings->get('core', 'productsPerPageAdmin');
$dataProvider->sort->route = 'applyCommentsFilter';
$dataProvider->pagination->route = 'applyCommentsFilter';

$this->widget('ext.sgridview.SGridView', array(
	'dataProvider' => $dataProvider,
	'id'           => 'productCommentsListGrid',
	'filter'       => $comments,
	'ajaxUrl'      => Yii::app()->createUrl('/store/admin/products/applyCommentsFilter', array('id'=>$model->id)),
	'enableHistory'=>false,
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
			'value' => 'CHtml::link(CHtml::encode($data->name), array("/comments/admin/comments/update", "id"=>$data->id))',
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
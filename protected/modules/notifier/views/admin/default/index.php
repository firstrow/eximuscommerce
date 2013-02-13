<?php
	// Display list of products waiting for notification

	$this->pageHeader = Yii::t('NotifierModule.core', 'Список продуктов для уведомления');

	$this->breadcrumbs = array(
		'Home'=>$this->createUrl('/admin'),
		Yii::t('NotifierModule.core', 'Уведомления'),
	);

	$this->widget('ext.sgridview.SGridView', array(
		'dataProvider' => $dataProvider,
		'id'           => 'productsList',
		'columns'=>array(
			array(
				'class' =>'SGridIdColumn',
				'name'  =>'id',
			),
			array(
				'name'=>'name',
				'type'=>'raw',
				'value'=>'CHtml::link(CHtml::encode($data->product->name), array("/store/admin/products/update", "id"=>$data->product->id))',
			),
			array(
				'name'  =>'product_availability',
				'type'  =>'raw',
				'value' =>'CHtml::encode($data->product->availabilityItems[$data->product->availability])',
			),
			array(
				'name'  =>'product_quantity',
				'type'  =>'raw',
				'value' =>'CHtml::encode($data->product->quantity)',
			),
			array(
				'name' => 'totalEmails'
			),
			array(
				'class' => 'CLinkColumn',
				'label' => 'Отправить письмо',
				'urlExpression' => 'Yii::app()->createUrl("notifier/admin/default/send", array("product_id"=>$data->product_id))',
				'linkHtmlOptions' => array(
					'confirm' => Yii::t('NotifierModule.core', 'Вы уверены?')
				)
			),
			array(
				'class'=>'CButtonColumn',
				'template'=>'{delete}',
			),
		),
	));


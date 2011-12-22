<?php

	/**
     * Display products list
     **/

	$this->pageHeader = Yii::t('StoreModule.admin', 'Продукты');

    $this->breadcrumbs = array(
        'Home'=>$this->createUrl('/admin'),
        Yii::t('StoreModule.admin', 'Продукты'),
    );

    $this->topButtons = $this->widget('application.modules.admin.widgets.SAdminTopButtons', array(
        'template'=>array('create'),
        'elements'=>array(
            'create'=>array(
                'link'=>$this->createUrl('create'),
                'title'=>Yii::t('StoreModule.admin', 'Создать продукт'),
                'options'=>array(
                    'icons'=>array('primary'=>'ui-icon-plus')
                )
            ),
        ),
    ));

    $this->widget('ext.sgridview.SGridView', array(
        'dataProvider'=>$model->search(),
        'id'=>'productsListGrid',
        'filter'=>$model,
        'columns'=>array(
            array(
                'class'=>'CCheckBoxColumn',
            ),
            array(
                'class'=>'SGridIdColumn',
                'name'=>'id'
            ),
            array(
                'name'=>'name',
                'type'=>'raw',
                'value'=>'CHtml::link(CHtml::encode($data->name), array("update", "id"=>$data->id))',
            ),
            array(
                'name'=>'url',
                'type'=>'raw',
                'value'=>'CHtml::link(CHtml::encode($data->url), array("/store/frontProduct/view", "url"=>$data->url), array("target"=>"_blank"))',
            ),
            'sku',
            'price',
            // Buttons
            array(
                'class'=>'CButtonColumn',
                'template'=>'{update}{delete}',
            ),
        ),
    ));

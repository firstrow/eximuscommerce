<?php

	/**
     * Display product categories
     **/

	$this->pageHeader = Yii::t('StoreModule.admin', 'Категории');

    $this->breadcrumbs = array(
        'Home'=>$this->createUrl('/admin'),
        Yii::t('StoreModule.admin', 'Категории'),
    );

    $this->topButtons = $this->widget('application.modules.admin.widgets.SAdminTopButtons', array(
        'template'=>array('create'),
        'elements'=>array(
            'create'=>array(
                'link'=>$this->createUrl('create'),
                'title'=>Yii::t('StoreModule.admin', 'Создать категорию'),
                'options'=>array(
                    'icons'=>array('primary'=>'ui-icon-plus')
                )
            ),
        ),
    ));

    $this->widget('ext.sgridview.SGridView', array(
        'dataProvider'=>$model,
        'id'=>'productsListGrid',
        //'filter'=>$model,
        'columns'=>array(
            array(
                'class'=>'CCheckBoxColumn',
            ),
            'id',
            array(
                'name'=>'name',
                'type'=>'raw',
                'value'=>'CHtml::link($data->nameWithLevel, array("update", "id"=>$data->id))',
            ),
            // Buttons
            array(
                'class'=>'CButtonColumn',
                'template'=>'{update}{delete}',
            ),
        ),
    ));

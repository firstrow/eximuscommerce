<?php

	/** 
     *Display category tree 
     **/

	$this->pageHeader = Yii::t('PagesModule.admin', 'Категории');

    $this->breadcrumbs = array(
        'Home'=>$this->createUrl('/admin'),
        Yii::t('PagesModule.admin', 'Категории'),
    );

    $this->topButtons = $this->widget('application.modules.admin.widgets.SAdminTopButtons', array(
        'template'=>array('create'),
        'elements'=>array(
            'create'=>array(
                'link'=>$this->createUrl('create'),
                'title'=>'Создать категорию',
                'icon'=>'plus',
            ),
        ),
    ));

    $this->widget('ext.sgridview.SGridView', array(
        'dataProvider'=>$tree,
        'id'=>'pageCategoryGrid',
        //'enablePagination'=>false,
        'columns'=>array(
            array(
                'class'=>'CCheckBoxColumn',
            ),
            array(
                'name'=>'id',
                'type'=>'html',
                'header'=>$model->getAttributeLabel("id"),
            ),
            array(
                'name'=>'name',
                'type'=>'html',
                'value'=>'CHtml::link($data->nameWithLevel, array("update", "id"=>$data->id), array("class"))',
                'header'=>$model->getAttributeLabel("name")
            ),
            array(
                'name'=>'url',
                'type'=>'raw',
                'value'=>'CHtml::link($data->url, $data->getViewUrl(), array("target"=>"_blank"))',
                'header'=>$model->getAttributeLabel("url"),
            ),
            array(
                'name'=>'pages',
                'type'=>'html',
                'value'=>'CHtml::link($data->pageCount, array("/pages/admin/default/index", "Page[category_id]"=>$data->id))',
                'header'=>$model->getAttributeLabel("pages"),
            ),
            array(
                'name'=>'created',
                'type'=>'raw',
                'header'=>$model->getAttributeLabel("created"),
            ),
            // Buttons
            array(
                'class'=>'CButtonColumn',
                'template'=>'{update}{delete}',
            ),
        ),
    ));

<?php

	/** Display pages list **/

	$this->pageHeader = Yii::t('PagesModule.admin', 'Страницы');

    $this->breadcrumbs = array(
        'Home'=>$this->createUrl('/admin'),
        Yii::t('PagesModule.admin', 'Страницы'),
    );

    $this->topButtons = $this->widget('application.modules.admin.widgets.SAdminTopButtons', array(
        'template'=>array('create'),
        'elements'=>array(
            'create'=>array(
                'link'=>$this->createUrl('create'),
                'title'=>'Создать',
                'icon'=>'plus',
            ),
        ),
    ));

    $this->widget('application.modules.admin.widgets.SGridView', array(
        'dataProvider'=>$model->search(),
        'id'=>'pagesListGrid',
        'filter'=>$model,
        'columns'=>array(
            'id',
            array(
                'name'=>'title',
                'type'=>'raw',
                'value'=>'CHtml::link($data->title, array("update", "id"=>$data->id))',
            ),
            'url',
            array(
                'name'=>'user_id',
                'type'=>'raw',
                'value'=>'$data->author->getUpdateLink()',
            ),
            'created',
            'updated',
            // Buttons
            array(
                'class'=>'CButtonColumn',
                'template'=>'{update}{delete}',
            ),
        ),
    ));
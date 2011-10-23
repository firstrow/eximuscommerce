<?php

	/** Display installed modules list **/

	$this->pageHeader = Yii::t('CoreModule.admin', 'Модули');

    $this->breadcrumbs = array(
        'Home'=>$this->createUrl('/admin'),
        Yii::t('CoreModule.admin', 'Модули'),
    );

    $this->topButtons = $this->widget('application.modules.admin.widgets.SAdminTopButtons', array(
        'template'=>array('new'),
        'elements'=>array(
            'new'=>array(
                'link'=>$this->createUrl('install'),
                'title'=>'Установить',
                'icon'=>'plus',
            ),
        ),
    ));

    $this->widget('application.modules.admin.widgets.SGridView', array(
        'dataProvider'=>$model->search(),
        'id'=>'modulesListGrid',
        'filter'=>$model,
        'columns'=>array(
            array(
                'name'=>'name',
                'value'=>'$data->getInfo()->name',
                'filter'=>false,
            ),
            array(
                'name'=>'description',
                'value'=>'$data->getInfo()->description',
                'header'=>'Описание',
                'filter'=>false,
            ),
            array(
            	'name'=>'enabled',
            	'value'=>'$data->enabled ? "Да":"Нет"',
            	'filter'=>array(1=>'Да',0=>'Нет'),
	        ), 
	        // Buttons
            array(
                'class'=>'CButtonColumn',
                'template'=>'{update}{delete}',
            ),
        ),
    ));
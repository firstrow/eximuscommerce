<?php 

    $this->breadcrumbs = array(
        'Home'=>$this->createUrl('/admin'),
        'Права доступа'=>Rights::getBaseUrl(),
        Rights::t('core', 'Tasks'),
    ); 

    $this->pageHeader =Rights::t('core', 'Tasks');
    
    $this->topButtons = $this->widget('application.modules.admin.widgets.SAdminTopButtons', array(
        'template'=>array('createTask'),
        'elements'=>array(
            'createTask'=>array(
                'link'=>array('authItem/create', 'type'=>CAuthItem::TYPE_TASK),
                'title'=>Rights::t('core', 'Create a new task'),
                'icon'=>'plus',
            ),
        ),
    ));
    
?>

<div id="tasks">

    <?php $this->beginClip('sidebarHelpText'); ?>
        <?php echo Rights::t('core', 'A task is a permission to perform multiple operations, for example accessing a group of controller action.'); ?><br />
        <?php echo Rights::t('core', 'Tasks exist below roles in the authorization hierarchy and can therefore only inherit from other tasks and/or operations.'); ?>
    <?php $this->endClip(); ?>
        
        <?php $this->sidebarContent = $this->renderPartial('/_menu',null,true); ?>

	<?php $this->widget('ext.sgridview.SGridView', array(
	    'dataProvider'=>$dataProvider,
	    'template'=>'{items}',
	    'emptyText'=>Rights::t('core', 'No tasks found.'),
	    'htmlOptions'=>array('class'=>'grid-view task-table'),
	    'columns'=>array(
    		array(
    			'name'=>'name',
    			'header'=>Rights::t('core', 'Name'),
    			'type'=>'raw',
    			'htmlOptions'=>array('class'=>'name-column'),
    			'value'=>'$data->getGridNameLink()',
    		),
    		array(
    			'name'=>'description',
    			'header'=>Rights::t('core', 'Description'),
    			'type'=>'raw',
    			'htmlOptions'=>array('class'=>'description-column'),
    		),
    		array(
    			'name'=>'bizRule',
    			'header'=>Rights::t('core', 'Business rule'),
    			'type'=>'raw',
    			'htmlOptions'=>array('class'=>'bizrule-column'),
    			'visible'=>Rights::module()->enableBizRule===true,
    		),
    		array(
    			'name'=>'data',
    			'header'=>Rights::t('core', 'Data'),
    			'type'=>'raw',
    			'htmlOptions'=>array('class'=>'data-column'),
    			'visible'=>Rights::module()->enableBizRuleData===true,
    		),
    		array(
    			'header'=>'&nbsp;',
    			'type'=>'raw',
    			'htmlOptions'=>array('class'=>'actions-column'),
    			'value'=>'$data->getDeleteTaskLink()',
    		),
	    )
	)); ?>

	<div class="hint"><?php echo Rights::t('core', 'Values within square brackets tell how many children each item has.'); ?></div>

</div>
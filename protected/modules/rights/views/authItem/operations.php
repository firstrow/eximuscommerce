<?php 

    $this->breadcrumbs = array(
        'Home'=>$this->createUrl('/admin'),
        'Права доступа'=>Rights::getBaseUrl(),
        Rights::t('core', 'Operations'),
    ); 
    
    $this->pageHeader = Rights::t('core', 'Operations');
    
    $this->topButtons = $this->widget('application.modules.admin.widgets.SAdminTopButtons', array(
        'template'=>array('createOperation'),
        'elements'=>array(
            'createOperation'=>array(
                'link'=>array('authItem/create', 'type'=>CAuthItem::TYPE_OPERATION),
                'title'=>Rights::t('core', 'Create a new operation'),
                'icon'=>'plus',
            ),
        ),
    ));    
    
?>

<div id="operations">

	<?php $this->beginClip('sidebarHelpText'); ?>
            <?php echo Rights::t('core', 'An operation is a permission to perform a single operation, for example accessing a certain controller action.'); ?><br />
            <?php echo Rights::t('core', 'Operations exist below tasks in the authorization hierarchy and can therefore only inherit from other operations.'); ?>
	<?php $this->endClip(); ?> 
            
        <?php $this->sidebarContent = $this->renderPartial('/_menu',null,true); ?>

	<?php $this->widget('zii.widgets.grid.CGridView', array(
	    'dataProvider'=>$dataProvider,
	    'template'=>'{items}',
            'cssFile'=>false,
	    'emptyText'=>Rights::t('core', 'No operations found.'),
	    'htmlOptions'=>array('class'=>'grid-view operation-table sortable-table'),
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
    			'value'=>'$data->getDeleteOperationLink()',
    		),
	    )
	)); ?>

	<div class="hint"><?php echo Rights::t('core', 'Values within square brackets tell how many children each item has.'); ?></div>

</div>
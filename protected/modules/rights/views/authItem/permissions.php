<?php 
    $this->breadcrumbs = array(
            'Home'=>$this->createUrl('/admin'),
            'Права доступа'=>Rights::getBaseUrl(),
            Rights::t('core', 'Permissions'),
    ); 
    
    $this->pageHeader = Rights::t('core', 'Permissions');
    
    $this->topButtons = $this->widget('application.modules.admin.widgets.SAdminTopButtons', array(
        'template'=>array('operationLink'),
        'elements'=>array(
            'operationLink'=>array(
                'link'=>array('authItem/generate'),
                'title'=>Rights::t('core', 'Generate items for controller actions'),
            ),
        ),
    ));
?>

<div id="rights">

    <div id="permissions">

        <?php $this->beginClip('sidebarHelpText'); ?>
            <p>
                <?php echo Rights::t('core', 'Here you can view and manage the permissions assigned to each role.'); ?><br />
                <?php echo Rights::t('core', 'Authorization items can be managed under {roleLink}, {taskLink} and {operationLink}.', array(
                        '{roleLink}'=>CHtml::link(Rights::t('core', 'Roles'), array('authItem/roles')),
                        '{taskLink}'=>CHtml::link(Rights::t('core', 'Tasks'), array('authItem/tasks')),
                        '{operationLink}'=>CHtml::link(Rights::t('core', 'Operations'), array('authItem/operations')),
                )); ?>
            </p>
        <?php $this->endClip(); ?>
            
        <?php $this->sidebarContent = $this->renderPartial('/_menu',null,true); ?>

	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$dataProvider,
		'template'=>'{items}',
                'cssFile'=>false,
		'emptyText'=>Rights::t('core', 'No authorization items found.'),
		'htmlOptions'=>array('class'=>'grid-view permission-table'),
		'columns'=>$columns,
	)); ?>

	<div class="hint">*) <?php echo Rights::t('core', 'Hover to see from where the permission is inherited.'); ?></div>

	<script type="text/javascript">
		/**
		* Attach the tooltip to the inherited items.
		*/
		jQuery('.inherited-item').rightsTooltip({
			title:'<?php echo Rights::t('core', 'Source'); ?>: '
		});

		/**
		* Hover functionality for rights' tables.
		*/
		$('#rights tbody tr').hover(function() {
			$(this).addClass('hover'); // On mouse over
		}, function() {
			$(this).removeClass('hover'); // On mouse out
		});
	</script>
    </div>
    
</div>
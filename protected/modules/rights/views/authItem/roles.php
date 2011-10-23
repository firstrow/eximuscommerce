<?php 

    $this->breadcrumbs = array(
        'Home'=>$this->createUrl('/admin'),
        'Права доступа'=>Rights::getBaseUrl(),
        Rights::t('core', 'Roles'),
    ); 

    $this->pageHeader = Rights::t('core', 'Roles');
    
    $this->topButtons = $this->widget('application.modules.admin.widgets.SAdminTopButtons', array(
        'template'=>array('createRole'),
        'elements'=>array(
            'createRole'=>array(
                'link'=>array('authItem/create', 'type'=>CAuthItem::TYPE_ROLE),
                'title'=>Rights::t('core', 'Create a new role'),
                'icon'=>'plus',
            ),
        ),
    ));
    
?>

<div id="roles">

    <?php $this->beginClip('sidebarHelpText'); ?>
        <?php echo Rights::t('core', 'A role is group of permissions to perform a variety of tasks and operations, for example the authenticated user.'); ?><br />
        <?php echo Rights::t('core', 'Roles exist at the top of the authorization hierarchy and can therefore inherit from other roles, tasks and/or operations.'); ?>
    <?php $this->endClip(); ?>
    
    <?php $this->sidebarContent = $this->renderPartial('/_menu',null,true); ?>

    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider'=>$dataProvider,
        'template'=>'{items}',
        'cssFile'=>false,
        'emptyText'=>Rights::t('core', 'No roles found.'),
        'htmlOptions'=>array('class'=>'grid-view role-table'),
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
                    'value'=>'$data->getDeleteRoleLink()',
            ),
        )
    )); ?>

    <div class="hint"><?php echo Rights::t('core', 'Values within square brackets tell how many children each item has.'); ?></div>

</div>
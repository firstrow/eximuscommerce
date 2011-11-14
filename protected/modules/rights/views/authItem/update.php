<?php 
    $this->breadcrumbs = array(
	    'Home'=>'/admin',
		'Права доступа'=>Rights::getBaseUrl(),
		Rights::getAuthItemTypeNamePlural($model->type)=>Rights::getAuthItemRoute($model->type),
		$model->name,
    );
    
    $this->pageHeader = Rights::t('core', 'Update :name', array(
        ':name'=>$model->name,
        ':type'=>Rights::getAuthItemTypeName($model->type),
    ));
    
    $this->sidebarContent = $this->renderPartial('/_menu', null, true);
?>

<div id="rights" class="">
<div id="updatedAuthItem">

	<?php $this->renderPartial('_form', array('model'=>$formModel)); ?>

	<div class="relations padding-all">

		<h3><?php echo Rights::t('core', 'Relations'); ?></h3>

		<?php if( $model->name!==Rights::module()->superuserName ): ?>

	<div class="form wide">
		<div class="row">
			<label><?php echo Rights::t('core', 'Parents'); ?></label>
			<div>
				<?php $this->widget('zii.widgets.grid.CGridView', array(
					'dataProvider'=>$parentDataProvider,
					'template'=>'{items}',
					'hideHeader'=>true,
					'emptyText'=>Rights::t('core', 'This item has no parents.'),
					'htmlOptions'=>array('class'=>''),
					'columns'=>array(
    					array(
    						'name'=>'name',
    						'header'=>Rights::t('core', 'Name'),
    						'type'=>'raw',
    						'htmlOptions'=>array('class'=>'name-column'),
    						'value'=>'$data->getNameLink()',
    					),
    					array(
    						'name'=>'type',
    						'header'=>Rights::t('core', 'Type'),
    						'type'=>'raw',
    						'htmlOptions'=>array('class'=>'type-column'),
    						'value'=>'$data->getTypeText()',
    					),
    					array(
    						'header'=>'&nbsp;',
    						'type'=>'raw',
    						'htmlOptions'=>array('class'=>'actions-column'),
    						'value'=>'',
    					),
					)
				)); ?>
			</div>
		</div>			

		<div class="row">
			<label><?php echo Rights::t('core', 'Children'); ?></label>
			<div>
				<?php $this->widget('zii.widgets.grid.CGridView', array(
					'dataProvider'=>$childDataProvider,
					'template'=>'{items}',
					'hideHeader'=>true,
					'emptyText'=>Rights::t('core', 'This item has no children.'),
					'htmlOptions'=>array('class'=>''),
					'columns'=>array(
						array(
							'name'=>'name',
							'header'=>Rights::t('core', 'Name'),
							'type'=>'raw',
							'htmlOptions'=>array('class'=>'name-column'),
							'value'=>'$data->getNameLink()',
						),
						array(
							'name'=>'type',
							'header'=>Rights::t('core', 'Type'),
							'type'=>'raw',
							'htmlOptions'=>array('class'=>'type-column'),
							'value'=>'$data->getTypeText()',
						),
						array(
							'header'=>'&nbsp;',
							'type'=>'raw',
							'htmlOptions'=>array('class'=>'actions-column'),
							'value'=>'$data->getRemoveChildLink()',
						),
					)
				)); ?>
			</div>
		</div>


		<div class="row">
			<label><?php echo Rights::t('core', 'Add Child'); ?></label>
			<div>
			<?php if( $childFormModel!==null ): ?>

				<?php $this->renderPartial('_childForm', array(
					'model'=>$childFormModel,
					'itemnameSelectOptions'=>$childSelectOptions,
				)); ?>

			<?php else: ?>

				<p class="info">
					<?php echo Rights::t('core', 'No children available to be added to this item.'); ?>
				</p>

			<?php endif; ?>
			</div>
		</div>
	</div>

	<?php else: ?>
		<p>
			<?php echo Rights::t('core', 'No relations need to be set for the superuser role.'); ?><br />
			<?php echo Rights::t('core', 'Super users are always granted access implicitly.'); ?>
		</p>
	<?php endif; ?>

	</div>
</div>
</div>
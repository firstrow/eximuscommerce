<?php

	/**
	 * Create/update product types
	 */

	$this->topButtons = $this->widget('application.modules.admin.widgets.SAdminTopButtons', array(
		'formId'=>'StoreProductTypeForm',
		//'langSwitcher'=>!$model->isNewRecord,
		'deleteAction'=>$this->createUrl('/store/admin/productType/delete', array('id'=>$model->id))
	));

	$title = ($model->isNewRecord) ? Yii::t('StoreModule.admin', 'Создание нового продукта') :
		Yii::t('StoreModule.admin', 'Редактирование типа продукта');

	$this->breadcrumbs = array(
		'Home'=>$this->createUrl('/admin'),
		Yii::t('StoreModule.admin', 'Типы продуктов')=>$this->createUrl('index'),
		($model->isNewRecord) ? Yii::t('StoreModule.admin', 'Создание нового продукта') : CHtml::encode($model->name),
	);

	$this->pageHeader = $title;

	// Register scripts
	Yii::app()->clientScript->registerScriptFile(
		$this->module->assetsUrl.'/admin/productType.update.js',
		CClientScript::POS_END
	);

?>

<div class="form wide padding-all">
	<?php
		echo CHtml::beginForm('', 'post',array(
			'id'=>'StoreProductTypeForm'
		));

		echo CHtml::errorSummary($model);
	?>

	<div class="row">
		<?php echo CHtml::activeLabel($model, 'name', array('required'=>true)); ?>
		<?php echo CHtml::activeTextField($model, 'name'); ?>
	</div>

	<div class="row">
		<label><?php echo Yii::t('StoreModule.admin', 'Атрибуты') ?></label>
		<table width="600px" class="attributesTable">
			<thead>
				<tr>
					<td><?php echo Yii::t('StoreModule.admin', 'Атрибуты продукта') ?></td>
					<td><?php echo Yii::t('StoreModule.admin', 'Доступные атрибуты') ?></td>
				</tr>
			</thead>
			<tbody>
				<tr valign="top">
					<td>
						<?php
						echo CHtml::dropDownList('attributes[]',
							null,
							CHtml::listData($model->storeAttributes, 'id', 'title'),
							array('multiple'=>true, 'class'=>'attributesList')
						);
						?>
					</td>
					<td>
						<?php
						echo CHtml::dropDownList('allAttributes',
							null,
							CHtml::listData($attributes, 'id', 'title'),
							array('multiple'=>true, 'class'=>'attributesList')
						);
						?>
					</td>
				</tr>
			</tbody>
		</table>
	</div>

	<?php echo CHtml::endForm(); ?>
</div><!-- end form -->

<style type="text/css">
	.attributesList {
		height: 350px;
	}
	table.attributesTable thead {
		font-weight: bold;
		color:#4C4C4C;
	}
	table.attributesTable thead td {
		padding: 5px;
	}
</style>
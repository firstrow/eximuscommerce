<?php

/**
 * Import
 */

$this->pageHeader = Yii::t('CsvModule.core', 'Экспорт продуктов');

$this->breadcrumbs = array(
	'Home'=>$this->createUrl('/admin'),
	Yii::t('CsvModule.admin', 'Модули')=>Yii::app()->createUrl('/core/admin/systemModules'),
	Yii::t('CsvModule.admin', 'Экспорт')
);

?>

<style type="text/css">
	.attributesTable tr td {
		padding:3px 3px 3px 3px;
		border:1px solid silver;
	}
	.attributesTable {
		margin: 5px 0 5px 0;
		border:1px solid silver;
	}
	.attributesTable tr:hover{
		background-color: #F9F9F9;
	}
	.attributesTable tr td input {
		margin: 3px;
	}
	.attributesTable tr td label {
		color: #000;
		cursor: pointer;
	}
</style>

<div class="padding-all form wide">

	<?php $form = $this->beginWidget('CActiveForm', array(
		'id'=>'priceExportForm',
	)); ?>

	<b><?php echo Yii::t('CsvModule.core', 'Доступны следующие поля:') ?></b>
	<table class="attributesTable">
		<?php
			foreach($importer->getImportableAttributes('eav_') as $k=>$v)
			{
				echo '<tr>';
				echo '<td width="200px"><label><input type="checkbox" checked name="attributes[]" value="'.$k.'">'.CHtml::encode($v).'</label></td>';
				echo '<td>'.$k.'</td>';
				echo '</tr>';
			}
		?>
	</table>

	<div class="row">
		<input type="submit" value="<?php echo Yii::t('CsvModule.core', 'Скачать') ?>">
	</div>
	
	<?php $this->endWidget(); ?>
</div>

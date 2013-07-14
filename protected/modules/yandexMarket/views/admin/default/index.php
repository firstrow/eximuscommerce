<?php

/**
 * @var $form CActiveForm
 */

$this->pageHeader = Yii::t('YandexMarketModule.admin', 'Настройка Yandex.Market');

$this->breadcrumbs = array(
	'Home'=>$this->createUrl('/admin'),
	Yii::t('YandexMarketModule.admin', 'Модули')=>Yii::app()->createUrl('/core/admin/systemModules'),
	Yii::t('YandexMarketModule.admin', 'Настройка Yandex.Market'
));

?>

<div class="form wide padding-all">
	<?php $form=$this->beginWidget('CActiveForm'); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name') ?>
		<span class="required"> *</span>
		<div class="hint"><?php echo Yii::t('YandexMarketModule','Название, которое выводится в списке найденных на Яндекс.Маркете товаров.') ?></div>
	</div>

	<div class="row">
		<?php echo $form->label($model,'company'); ?>
		<?php echo $form->textField($model,'company') ?>
		<span class="required"> *</span>
		<div class="hint"><?php echo Yii::t('YandexMarketModule','Полное наименование компании, владеющей магазином..') ?></div>
	</div>

	<div class="row">
		<?php echo $form->label($model,'url'); ?>
		<?php echo $form->textField($model,'url') ?>
		<span class="required"> *</span>
		<div class="hint"><?php echo Yii::t('YandexMarketModule','URL-адрес главной страницы магазина.') ?></div>
	</div>

	<div class="row">
		<?php echo $form->label($model,'currency_id'); ?>
		<?php echo $form->dropDownList($model,'currency_id', $model->getCurrencies()) ?>
		<span class="required"> *</span>
	</div>

	<div class="row">
		<label></label>
		<a href="/yandex-market.xml">Просмотреть файл</a>
	</div>

	<div class="row submit">
		<label>&nbsp;</label>
		<?php echo CHtml::submitButton(Yii::t('YandexMarketModule.admin', 'Сохранить')); ?>
	</div>

	<?php $this->endWidget(); ?>
</div><!-- form -->

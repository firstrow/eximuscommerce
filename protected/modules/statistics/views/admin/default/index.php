<?php
$this->breadcrumbs = array(
	'Home'=>$this->createUrl('/admin'),
	Yii::t('StatisticsModule.admin', 'Статистика')
);

/** @var $clientScript CClientScript */
$clientScript = Yii::app()->getClientScript();
$clientScript->registerCssFile($this->module->assetsUrl . '/morris/morris.css');
$clientScript->registerScriptFile($this->module->assetsUrl . '/raphael-min.js');
$clientScript->registerScriptFile($this->module->assetsUrl . '/morris/morris.min.js');

?>


<div class="padding-all">
    <h3>Количество заказов по дням</h3>
    <form action="" method="get">
		Год: <?= CHtml::dropDownList('year', $year, $this->getAvailableYears(), array('onchange'=>'this.form.submit()')) ?>
		Месяц: <?= CHtml::dropDownList('month', $month, array(1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10,11=>11,12=>12),array('onchange'=>'this.form.submit()')) ?>
	</form>

    <div id="orders" style="height: 350px;"></div>
    <h3>Сумма заказов</h3>
    <div id="orders_total_price" style="height: 350px;"></div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		new Morris.Line({
			element: 'orders',
			data: <?= json_encode($data) ?>,
			xkey: 'day',
			ykeys: ['value'],
			labels: ['Заказы'],
			parseTime: false
		});

		new Morris.Line({
			element: 'orders_total_price',
			data: <?= json_encode($data_total) ?>,
			xkey: 'day',
			ykeys: ['value'],
			labels: ['Сумма заказов'],
			parseTime: false
		});
	});
</script>

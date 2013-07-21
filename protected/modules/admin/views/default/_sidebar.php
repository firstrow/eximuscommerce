
	<br><br>

	<h3><?=Yii::t('AdminModule.admin', 'Сумма заказов за сегодня:')?></h3>
	<div class="blockContent" style="font-size: 18px">
		<a href="/admin/statistics"><?=$ordersTotalPrice?> <?=Yii::app()->currency->main->symbol?></a>
	</div>

	<br>

	<h3><?=Yii::t('AdminModule.admin', 'Комментариев за сегодня:')?></h3>
	<div class="blockContent" style="font-size: 18px">
		<a href="/admin/comments"><?=$this->countTodayComments()?></a>
	</div>


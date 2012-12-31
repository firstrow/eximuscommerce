<?php
	$this->breadcrumbs = array(
		'Home'=>$this->createUrl('/admin'),
		Yii::t('AdminModule.core', 'Ошибка'),
	);
?>

<div style="padding: 15px;">
	<div>
		<?= $error['message'] ?>
	</div>
	<?php if(YII_DEBUG): ?>
		<div style="margin-top: 10px;">
			<b>Файл:</b> <?= $error['file'] ?><br>
			<b>Строка:</b> <?= $error['line'] ?>

			<pre style="margin-top: 10px;"><?= $error['trace'] ?>
			</pre>
		</div>
	<?php endif ?>
	<div>
		<br>
		<a href="javascript:history.back(-1)">&larr; Назад</a>
	</div>
</div>
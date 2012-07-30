<?php if (YII_DEBUG===true && $error): ?>
	<h2><?=$error['type']?></h2>

	<div class="error">
		<?=$error['message']?>
	</div>

<?php else: ?>

	<h2><?=Yii::t('core','Ошибка')?></h2>

	<div class="error">
		<?=Yii::t('core','Ошибка обработки запроса.')?>
	</div>
<?php endif ?>
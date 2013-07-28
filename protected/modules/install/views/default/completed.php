<div class="progress">
	1→2→3→<span class="active">4</span>
</div>

<h1><?php echo Yii::t('InstallModule.core','Установка завершена.') ?></h1>

<div class="line"></div>

<div style="color: maroon;margin-bottom: 15px;"><?php echo Yii::t('InstallModule.core', 'Для завершения установки удалите файл install.php') ?></div>

<?php echo CHtml::link(Yii::t('InstallModule.core', 'Посмотреть сайт'),'/')?>
<br/>
<?php echo CHtml::link(Yii::t('', 'Панель управления'),'/admin')?>


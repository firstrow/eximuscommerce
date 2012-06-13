<?php
/**
 * Step 1.
 * Check configuration.
 */
$errors=false;
?>

<h1><?php echo Yii::t('InstallModule.core','Шаг 1. Проверка.') ?></h1>

<div class="line"></div>

<div class="form">
	<div class="m20">
		<?php echo Yii::t('InstallModule.core','Следующий список директорий и файлов должен быть доступен для записи.'); ?>
	</div>
	<table class="stripy" cellpadding="3" cellspacing="3">
		<?php foreach($this->writeAble as $path): ?>
		<tr>
			<td width="300px"><?php echo $path ?></td>
			<td>
				<?php
					$result=$this->isWritable($path);
					if($result)
						echo '<span class="green">OK</span>';
					else
					{
						$errors=true;
						echo '<span class="red">NO</span>';
					}
				?>
			</td>
		</tr>
		<?php endforeach ?>
	</table>

	<div class="row buttons">
		<?php if(!$errors): ?>
		<form action="" method="post">
			<input type="hidden" name="ok" value="1">
			<input type="submit" value="<?php echo Yii::t('InstallModule.core','Продолжить'); ?>">
		</form>
		<?php else: ?>
		<div class="m20">
			<?php echo Yii::t('InstallModule.core','Исправьте ошибки и нажмите <a href="/install.php">Обновить</a>'); ?>
		</div>
		<?php endif ?>
	</div>
</div>

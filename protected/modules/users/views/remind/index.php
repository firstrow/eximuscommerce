<?php
/**
 * Remind user password view
 */

$this->pageTitle = Yii::t('UsersModule.core','Напомнить пароль');
?>

<h1 class="has_background"><?php echo Yii::t('UsersModule.core','Напомнить пароль'); ?></h1>

<div class="login_box rc5">
	<div class="form wide">
		<?php
		echo CHtml::form();
		echo CHtml::errorSummary($model);
		?>

		<div class="row">
			<?php echo CHtml::activeLabel($model,'email', array('required'=>true)); ?>
			<?php echo CHtml::activeTextField($model,'email'); ?>
		</div>

		<div class="row buttons">
			<input type="submit" class="blue_button" value="<?php echo Yii::t('UsersModule.core','Напомнить'); ?>">
		</div>

		<div class="row buttons">
			<?php echo CHtml::link(Yii::t('UsersModule', 'Регистрация'), array('register/register')) ?><br>
			<?php echo CHtml::link(Yii::t('UsersModule', 'Авторизация'), array('login/login')) ?><br>
		</div>
		<?php echo CHtml::endForm(); ?>
	</div>
</div>

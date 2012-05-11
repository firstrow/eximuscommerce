<?php

/**
 * @var UserLoginForm $model
 * @var Controller $this
 */

$this->pageTitle = Yii::t('UsersModule.core','Авторизация');
?>

<h1 class="has_background"><?php echo Yii::t('UsersModule.core','Авторизация'); ?></h1>

<div class="login_box rc5">
	<div class="form wide">
		<?php
			echo CHtml::form();
			echo CHtml::errorSummary($model);
		?>

		<div class="row">
			<?php echo CHtml::activeLabel($model,'username', array('required'=>true)); ?>
			<?php echo CHtml::activeTextField($model,'username'); ?>
		</div>

		<div class="row">
			<?php echo CHtml::activeLabel($model,'password', array('required'=>true)); ?>
			<?php echo CHtml::activePasswordField($model,'password'); ?>
		</div>

		<div class="row">
			<?php echo CHtml::activeLabel($model,'rememberMe'); ?>
			<?php echo CHtml::activeCheckBox($model,'rememberMe'); ?>
		</div>

			<div class="row buttons">
				<input type="submit" class="blue_button" value="<?php echo Yii::t('UsersModule.core','Вход'); ?>">
			</div>

			<div class="row buttons">
				<?php echo CHtml::link(Yii::t('UsersModule', 'Регистрация'), array('register/register')) ?><br>
				<a href="#">Напомнить пароль</a>
			</div>
		<?php echo CHtml::endForm(); ?>
	</div>
</div>

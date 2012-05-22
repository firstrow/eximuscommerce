<?php
	$assetsManager = Yii::app()->clientScript;
	$assetsManager->registerCoreScript('jquery');
	$assetsManager->registerCoreScript('jquery.ui');

	// Disable jquery-ui default theme
	$assetsManager->scriptMap=array(
		'jquery-ui.css'=>false,
	);
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo CHtml::encode($this->pageTitle) ?></title>
	<meta name="description" content="<?php echo CHtml::encode($this->pageDescription) ?>">
	<meta name="keywords" content="<?php echo CHtml::encode($this->pageKeywords) ?>">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl ?>/assets/css/reset.css">
	<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl ?>/assets/css/style.css">
	<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl ?>/assets/css/catalog.css">
	<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl ?>/assets/css/forms.css">
	<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/jqueryui/css/custom-theme/jquery-ui-1.8.19.custom.css">

	<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/common.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/menu.js"></script>
</head>
<body>
<div id="header">
	<!-- Small top menu -->
	<div id="top_menu">
		<div class="left">
			<ul>
				<li><a href="#">Помощь</a></li>
				<li><a href="#">Как сделать заказ</a></li>
				<li><a href="#">Гарантия</a></li>
				<li><a href="#">Доставка и оплата</a></li>
				<li><a href="#">Контакты</a></li>
			</ul>
		</div>
		<div class="right">
			<ul>
				<li>
					<a href="<?php echo Yii::app()->createUrl('/store/compare/index') ?>">
						<span class="icon compare"></span><?php echo Yii::t('core', 'Товары на сравнение') ?>
					</a>
				</li>
				<li><a href=""><span class="icon heart"></span>Список желаний</a></li>
			</ul>
		</div>
	</div>

	<div class="blocks">
		<div class="left">
			<a href="/"><img id="logo" src="<?php echo Yii::app()->theme->baseUrl ?>/assets/images/logo.png"></a>
		</div>
		<div class="middle">
			<span class="icon phone"></span>
			(099) <span class="big_text">111-222-333</span>

			<div class="currencies">
				<?php echo Yii::t('core','Валюта:') ?>
				<?
					foreach(Yii::app()->currency->currencies as $currency)
					{
						echo CHtml::ajaxLink($currency->symbol, '/store/ajax/activateCurrency/'.$currency->id, array(
							'success'=>'js:function(){window.location.reload(true)}',
						),array('id'=>'sw'.$currency->id,'class'=>Yii::app()->currency->active->id===$currency->id?'active':''));
					}
				?>
			</div>

			<div class="search_box">
				<?php echo CHtml::form($this->createUrl('/store/category/search')) ?>
					<input type="text" value="Поиск товаров" name="q" id="searchQuery">
					<button type="submit">Поиск</button>
				<?php echo CHtml::endForm() ?>
			</div>
		</div>
		<div class="right">
			<div id="auth">
				<?php if(Yii::app()->user->isGuest): ?>
					<?php echo CHtml::link(Yii::t('core','Вход'), array('/users/login/login'), array('class'=>'light')) ?>
					/
					<?php echo CHtml::link(Yii::t('core','Регистрация'), array('/users/register'), array('class'=>'light')) ?>
				<?php else: ?>
					<?php echo CHtml::link(Yii::t('core','Личный кабинет'), array('/users/profile/index'), array('class'=>'light')) ?>
					/
				<?php echo CHtml::link(Yii::t('core','Выход'), array('/users/login/logout'), array('class'=>'light')) ?>
				<?php endif; ?>
			</div>

			<div id="cart">
				<?php $this->renderFile(Yii::getPathOfAlias('orders.views.cart._small_cart').'.php'); ?>
			</div>
		</div>
	</div>

	<div class="mainm">
		<?php
			Yii::import('application.modules.store.models.StoreCategory');
			$items = StoreCategory::model()->findByPk(1)->asCMenuArray();
			$this->widget('application.extensions.mbmenu.MbMenu',array(
					'cssFile'=>Yii::app()->theme->baseUrl.'/assets/css/menu.css',
					'htmlOptions'=>array('class'=>'dropdown', 'id'=>'nav'),
					'items'=>$items['items'])
			);
		?>
	</div>
</div>

<div id="content">
	<?php if(($messages = Yii::app()->user->getFlash('messages'))): ?>
		<div class="flash_messages">
			<button class="close">×</button>
			<?php
				if(is_array($messages))
					echo implode('<br>', $messages);
				else
					echo $messages;
			?>
		</div>
	<?php endif; ?>

	<?php echo $content; ?>
</div><!-- content end -->

<div style="clear:both;"></div>

<?php if (isset($this->clips['underFooter'])) echo $this->clips['underFooter']; ?>

<div id="footer">
	<div class="centered">
		<div class="left">
			© «Интернет магазин», 2012
			<span class="light">Все права защищены</span>
		</div>

		<div class="middle">
			<ul>
				<li><a href="#">Помощь</a></li>
				<li><a href="#">Как сделать заказ</a></li>
				<li><a href="#">Гарантия</a></li>
				<li><a href="#">Доставка и оплата</a></li>
				<li><a href="#">Контакты</a></li>
			</ul>
		</div>
		<div class="right">
			Контактная информация
			<br/>
			(099) <span class="big_text">111-222-333</span>
		</div>
	</div>
</div>
</body>
</html>
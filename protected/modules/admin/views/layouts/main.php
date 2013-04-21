<?php
	// Register jquery and jquery ui.
	$adminAssetsUrl = Yii::app()->getModule('admin')->assetsUrl;

	$assetsManager = Yii::app()->clientScript;
	$assetsManager->registerCoreScript('jquery');
	$assetsManager->registerCoreScript('jquery.ui');

	// Disable jquery-ui default theme
	$assetsManager->scriptMap=array(
		'jquery-ui.css'=>false,
	);

	$assetsManager->registerCssFile($adminAssetsUrl.'/css/yui-grids/reset-fonts-grids.css');
	$assetsManager->registerCssFile($adminAssetsUrl.'/css/base.css');
	$assetsManager->registerCssFile($adminAssetsUrl.'/css/forms.css');
	$assetsManager->registerCssFile($adminAssetsUrl.'/css/breadcrumbs/style.css');
	$assetsManager->registerCssFile($adminAssetsUrl.'/vendors/jquery_ui/css/custom-theme/jquery-ui-1.8.14.custom.css');
	$assetsManager->registerCssFile($adminAssetsUrl.'/css/theme.css');

	// jGrowl
	Yii::import('ext.jgrowl.Jgrowl');
	Jgrowl::register();

	// Back Button & Query Library
	$assetsManager->registerScriptFile($adminAssetsUrl.'/vendors/jquery.ba-bbq.min.js');

	// Init script
	$assetsManager->registerScriptFile($adminAssetsUrl.'/scripts/init.scripts.js');
	$assetsManager->registerScriptFile($adminAssetsUrl.'/scripts/red_circles.js');
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>EximusCommerce - Admin</title>

	<style type="text/css">
		/*** Fix for tabs. ***/
		.ui-tabs {
			border:0;
		}
		.xdebug-var-dump {
			background-color:silver;
		}
	</style>
</head>
<body style="text-align:left;">

<!--
	yui-t1,3: sidebar left

	// For fixed width
	<div style="width: 80%;" class="yui-t5">
-->
<div id="doc3" class="yui-t6">
	<div id="hd">
		<div class="yui-gc">
			<div class="yui-u first">
				<?php
					$this->widget('application.modules.admin.widgets.SSystemMenu');
				?>
			</div>
			<div class="yui-u" id="topRightMenu">
				<form action="/admin/store/products/" method="get" id="topSearchForm">
					<input type="text" name="StoreProduct[name]" id="topSearchBox">
				</form>

				<?php echo CHtml::link(Yii::t('AdminModule.admin', 'Выход ({name})', array('{name}'=>Yii::app()->user->model->username)), array('/admin/auth/logout'), array(
					'confirm'=>Yii::t('StoreModule.admin','Завершить сеанс?')
				)) ?>
			</div>
		</div>
	</div> <!-- /hd -->

	<div class="yui-gc" id="navigation">
		<div class="yui-u first" style="width:1px;">
			<div class="navigation-content-left">
				<div id="breadcrumbs" class="breadCrumb module">

					<div>
						<?php
							$this->widget('application.modules.admin.widgets.SAdminBreadcrumbs', array(
								'homeLink'=>$this->createUrl('admin'),
								'links'=>$this->breadcrumbs,
							));
						?>
					</div>
				</div>

			</div>
		</div>
		<div class="yui-u" style="width:50%;">
			<div class="navigation-content-right marright" align="right" style="float:right;">
				<div style="float:right;">
				<?php
					if (!empty($this->topButtons))
						echo $this->topButtons;
				?>
				</div>
			</div>
		</div>
	</div>

	<div id="bd" class="marleft">
		<div id="yui-main">
			<?php if (isset($this->pageHeader) && !empty($this->pageHeader)) echo '<h3>'.CHtml::encode($this->pageHeader).'</h3>'; ?>

			<!-- Remove yui-b class for full wide -->
			<?php if (!empty($this->sidebarContent)) { ?>
				<div class="yui-b marright">
			<?php }else{ ?>
				<div class="marright">
			<?php } ?>
				<!-- Main content -->
				<?php
					if(($messages = Yii::app()->user->getFlash('messages')))
					{
						echo '<script type="text/javascript">';
						foreach ($messages as $m)
						{
							echo '$.jGrowl("'.CHtml::encode($m).'",{position:"bottom-right"});';
						}
						echo '</script>';
					}
				?>
				<div id="content" class="yui-g">
				<!-- <hr /> -->
					<?php
						echo $content;
					?>
				</div>
			</div>
		</div>
		<!-- Sidebar content -->
		<?php if (!empty($this->sidebarContent)) { ?>
			<div id="sidebar" class="yui-b marleft">
			<?php echo $this->sidebarContent; ?>
			<!--
			<h3>Меню</h3>
			<hr/>

			<div class="sidebarBlock marright">
				<h3>Block Header</h3>
				<div class="blockContent">
					<form>
						<input type="text" />
					</form>
				</div>
			</div>
			-->
			</div><!-- /sidebar -->
		<?php } ?>
	</div>

	<!-- footer -->
	<div id="ft" style="height:50px;">
		&nbsp;
		<?php
			Yii::import('application.modules.admin.components.SLicenseChecker');
			if(SLicenseChecker::check()===false):
		?>
		<div style="text-align: center;color:maroon;">
			Для покупки лицензии посетите <a href="http://eximuscommerce.com" target="_blank">eximuscommerce.com</a>
		</div>
		<?php endif ?>
	</div>

</div>
</body>
</html>

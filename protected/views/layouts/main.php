<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php echo CHtml::encode($this->pageTitle) ?></title>
		<meta name="description" content="<?php echo CHtml::encode($this->pageDescription) ?>">
		<meta name="keywords" content="<?php echo CHtml::encode($this->pageKeywords) ?>">

		<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
		<!--[if lt IE 9]>
		  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<!-- Le styles -->
		<link href="/themes/development/assets/bootstrap.min.css" rel="stylesheet">
		<style type="text/css">
		  body {
			padding-top: 60px;
		  }
		</style>
	</head>

  <body>

	<div class="topbar">
	  <div class="topbar-inner">
		<div class="container-fluid">
		  <a class="brand" href="#">CMS</a>
		  <ul class="nav">
			<li><a href="/">Главная</a></li>
		  </ul>
		  <p class="pull-right">Logged in as <a href="#">username</a></p>

			<?php
				Yii::import('application.modules.store.models.StoreCategory');
				$items = StoreCategory::model()->findByPk(1)->asCMenuArray();
				$this->widget('application.extensions.mbmenu.MbMenu',array(
					'cssFile'=>'/themes/development/assets/mbmenu.css',
					'htmlOptions'=>array('class'=>'nav'),
					'items'=>$items['items'])
				);
			?>

		</div>
	  </div>
	</div>

	<div class="container-fluid">
	  <div class="sidebar">
		<div class="well">
		  <h5>Sidebar</h5>
		</div>
	  </div>

	  <div class="content">
		<div>
		  <?php
			$this->widget('zii.widgets.CBreadcrumbs', array(
				'links'=>$this->breadcrumbs,
				'separator'=>'<span class="divider">/</span>',
				'htmlOptions'=>array(
				  'class'=>'breadcrumb',
				)
			));
		  ?>
		</div>

		<div class="well">
		  <?php echo $content; ?>
		</div>
	  </div>
	</div>

  </body>
</html>
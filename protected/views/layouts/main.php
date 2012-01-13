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

			<?php $this->widget('application.extensions.mbmenu.MbMenu',array(
			'items'=>array(
				array('label'=>'Home', 'url'=>array('/site/index')),
				array('label'=>'Contact', 'url'=>array('/site/contact'),
					'items'=>array(
						array('label'=>'sub 1 contact'),
						array('label'=>'sub 2 contact'),
					),
				),
				array('label'=>'Test',
					'items'=>array(
						array('label'=>'Sub 1', 'url'=>array('/site/page','view'=>'sub1')),
						array('label'=>'Sub 2',
							'items'=>array(
								array('label'=>'Sub sub 1', 'url'=>array('/site/page','view'=>'subsub1')),
								array('label'=>'Sub sub 2', 'url'=>array('/site/page','view'=>'subsub2')),
							),
						),
					),
				),
			),
		)); ?>

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
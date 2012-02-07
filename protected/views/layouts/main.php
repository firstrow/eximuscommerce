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
		<link href="/themes/development/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="/themes/development/assets/style.css" rel="stylesheet">
		<style type="text/css">
		  body {
			padding-top: 60px;
		  }
		</style>
	</head>

  <body>

  <div class="navbar navbar-fixed-top">
	  <div class="navbar-inner">
		  <div class="container">
			  <a class="brand" href="/">Eximius</a>
			  <div class="nav-collapse">
					<?php
						Yii::import('application.modules.store.models.StoreCategory');
						$items = StoreCategory::model()->findByPk(1)->asCMenuArray();
						$this->widget('application.extensions.mbmenu.MbMenu',array(
							'cssFile'=>'/themes/development/assets/mbmenu.css',
							'htmlOptions'=>array('class'=>'nav'),
							'items'=>$items['items'])
						);
					?>
				<div class="navbar-text pull-right" style="float: right;">Logged in as <a href="#">username</a></div>
			  </div><!--/.nav-collapse -->
		  </div>
	  </div>
  </div>

<div class="container">
	<div class="row">
        <?php if(!empty($this->sidebarContent)): ?>
		<div class="span3">
			<div class="well sidebar-nav">
				<?php
					echo $this->sidebarContent;
				?>
			</div>
		</div>
        <?php endif; ?>

        <?php
            if(!empty($this->sidebarContent))
                echo '<div class="span9">';
            else
                echo '<div>';
        ?>
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
</div>

  </body>
</html>
<?php
	// Register jquery and jquery ui.
	Yii::app()->getClientScript()->registerCoreScript('jquery');  
	Yii::app()->getClientScript()->registerCoreScript('jquery.ui'); 
?>

<!doctype html> 
<html>
<head>
	<meta charset="utf-8">
	<title>CMS</title>

    <link rel="stylesheet" type="text/css" href="<?php echo $this->module->assetsUrl ?>/vendors/jquery_ui/css/ui-lightness/jquery-ui-1.8.14.custom.css">

	<link rel="stylesheet" type="text/css" href="<?php echo $this->module->assetsUrl ?>/css/yui-grids/reset-fonts-grids.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $this->module->assetsUrl ?>/css/base.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $this->module->assetsUrl ?>/css/forms.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $this->module->assetsUrl ?>/css/theme.css">

	<!-- Vendors -->
	<!-- Css3 buttons -->
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $this->module->assetsUrl ?>/vendors/css3buttons/stylesheets/css3buttons.css">

</head>
<body>

<div id="doc3" class="yui-t" style="width:750px;margin:auto;margin-top:150px;">

	<div id="bd" class="marleft">
		<div id="yui-main">
            <!-- Remove yui-b class for full wide -->
			<div class="yui-b marright">
				<!-- Main content -->
				<h3><span style="background-color:#1e90ff;padding:3px;color:#fff;">E</span>ximius</h3>
				<div id="content" class="yui-g">
                <!-- <hr />-->
					<?php 
						echo $content;;
					?>
				</div>
			</div>
		</div>
	</div>
	
	<div id="ft">
		<!-- footer -->
        &nbsp;
	</div>
</div>
</body>
</html>

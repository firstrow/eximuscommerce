<?php
    // TODO: Remove jquery-ui default theme
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
    $assetsManager->registerCssFile($adminAssetsUrl.'/css/theme.css');
    $assetsManager->registerCssFile($adminAssetsUrl.'/vendors/jquery_ui/css/custom-theme/jquery-ui-1.8.14.custom.css');
    // $assetsManager->registerCssFile('http://taitems.github.com/Aristo-jQuery-UI-Theme/css/Aristo/Aristo.css');

?>
<!doctype html> 
<html>
<head>

    <style>
        .xdebug-var-dump {
            background-color:silver;
        }
    </style>

	<meta charset="utf-8">
	<title>CMS</title>

    <!-- VENDORS -->
    <!-- Css3 buttons -->
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $adminAssetsUrl ?>/vendors/css3buttons/stylesheets/css3buttons.css">

    <!-- jquery breadcrumbs -->
    <script src="<?php echo $adminAssetsUrl ?>/vendors/breadCrumbs/jquery.jBreadCrumb.1.1.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?php echo $adminAssetsUrl ?>/vendors/breadCrumbs/BreadCrumb.css" type="text/css">
    <script type="text/javascript">
        jQuery(document).ready(function()
        {
            jQuery("#breadcrumbs").jBreadCrumb();
        })
   </script>

    <!-- ToTop -->
    <link rel="stylesheet" type="text/css" media="screen,projection" href="<?php echo $adminAssetsUrl ?>/vendors/jquery.ui.totop/ui.totop.css" />
    <script src="<?php echo $adminAssetsUrl ?>/vendors/jquery.ui.totop/jquery.ui.totop.js" type="text/javascript"></script>
    <script type="text/javascript"> 
            $(document).ready(function() {
                    $().UItoTop({ easingType: 'easeOutQuart' });
            });
    </script>     

    <!-- jGrowl -->
    <link rel="stylesheet" type="text/css" href="<?php echo $adminAssetsUrl ?>/vendors/jgrowl/jquery.jgrowl.css">
    <script src="<?php echo $adminAssetsUrl ?>/vendors/jgrowl/jquery.jgrowl.js"></script>
    
    <!-- Script to move navigation bar on scroll -->
    <script type="text/javascript">
        $(window).load(function (){
            var topBar = $('#navigation');
            var start  = topBar.offset().top;
            var fixed;
            $(window).scroll(function () {
                if(!fixed && (topBar.offset().top - $(window).scrollTop() < 0)){
                    topBar.css('top', 0);
                    topBar.css('position', 'fixed');
                    topBar.css('width', $('#doc3').css('width'));
                    topBar.css('opacity', '0.92');
                    $("#hd").css('margin-bottom','38px');
                    fixed = true;
                }else if(fixed && $(window).scrollTop() <= start){
                    topBar.css('position', '');
                    topBar.css('width', '');
                    topBar.css('opacity', '1');
                    $("#hd").css('margin-bottom','');
                    fixed = false;
                }
            });
        });
    </script>

    <style type="text/css">
        /*** Fix for tabs. ***/
        .ui-tabs {
            border:0;
        }
    </style>

</head>
<body>

<div id="doc3" class="yui-t6">
	<div id="hd">
		<div class="yui-gc">
                    <div class="yui-u first">
                        <?php
                            $this->widget('application.modules.admin.widgets.SSystemMenu');
                        ?>
                    </div>
                    <div class="yui-u" id="topRightMenu">
                        <a href="#">Настройки</a>
                        <a href="/admin/auth/logout">Выход</a>
                    </div>
		</div>
	</div> <!-- /hd -->

        <div class="yui-gc" id="navigation">
                    <div class="yui-u first" style="width:1px;">
                    <div class="navigation-content-left">
                        <div id="breadcrumbs" class="breadCrumb module">
                            <div style="overflow:hidden; position:relative;  width: 990px;">
                            <div>
                                <?php
                                $this->widget('application.modules.admin.widgets.SAdminBreadcrumbs', array(
                                    'homeLink'=>$this->createUrl('admin'),
                                    'links'=>$this->breadcrumbs,
                                ));
                                ?>  
                            </div></div >
                        </div>

                    </div>
            </div>
            <div class="yui-u" style="width:50%;">
                <div class="navigation-content-right marright" align="right">
                    <?php
                        if (!empty($this->topButtons))
                        {
                            echo $this->topButtons;
                        }
                    ?>
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
                            echo '<script>';
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
                <ul>
                    <li><a href="#">Страницы</a></li>
                    <li><a href="#">Категории</a></li>
                    <li><a href="#">Модули</a></li>
                    <li><a href="#">Меню</a></li>
                    <li><a href="#">Настройки</a></li>
                    <li><a href="#">Система</a></li>
                </ul>

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
	
	<div id="ft">
            <!-- footer -->
            &nbsp;
	</div>
</div>
</body>
</html>

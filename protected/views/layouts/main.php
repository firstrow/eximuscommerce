<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>CMS development theme</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le styles -->
    <link href="http://twitter.github.com/bootstrap/1.3.0/bootstrap.min.css" rel="stylesheet">
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
                'links'=>array(
                    'Sample post'=>array('post/view', 'id'=>12),
                    'Edit',
                ),
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
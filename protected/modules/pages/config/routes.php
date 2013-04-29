<?php

return array(
	// Display page by url
	'page/<url>'=>'pages/pages/view',
	// Display pages by category
	//'category/<url>'=>'pages/pages/list',
	array(
		'class' => 'application.modules.pages.config.CategoryUrlRule',
		'connectionID' => 'db',
		'urlSuffix'=>'.html',
	),
);
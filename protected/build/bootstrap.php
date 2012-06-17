<?php

// change the following paths if necessary
$yiit=dirname(__FILE__).'/../../framework/yiit.php';
$config=dirname(__FILE__).'/../config/main.php';

require_once($yiit);

Yii::createWebApplication($config);

// Activate languages
Yii::app()->languageManager->setActive();

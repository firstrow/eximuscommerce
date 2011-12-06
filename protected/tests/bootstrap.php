<?php

// change the following paths if necessary
$yiit=dirname(__FILE__).'/../../../yii1.1.8/yiit.php';
$config=dirname(__FILE__).'/../config/test.php';

require_once($yiit);
require_once(dirname(__FILE__).'/WebTestCase.php');

Yii::createWebApplication($config);

// Activate languages
Yii::app()->languageManager->setActive();
